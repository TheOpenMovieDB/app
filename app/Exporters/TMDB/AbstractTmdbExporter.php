<?php

declare(strict_types=1);

namespace App\Exporters\TMDB;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

abstract readonly class AbstractTmdbExporter
{
    protected string $date;
    protected string $filePath;
    protected string $url;
    protected Filesystem $disk;

    public function __construct(
        protected string $baseUrl,
        protected string $mediaType,
        protected string $diskName = 'tmdb_files'
    ) {
        $this->date = now()->format('m_d_Y');
        $this->filePath = "{$this->mediaType}_ids_{$this->date}.json";
        $this->url = sprintf($this->baseUrl, $this->date);
        $this->disk = Storage::disk($this->diskName);
    }

    /**
     * Process the export - template method pattern
     */
    public function export(bool $getFileContent = false): string|false
    {
        if ( ! $this->disk->exists($this->filePath)) {
            $this->downloadAndStore();
        }

        return $getFileContent
            ? $this->getFileContent()
            : $this->filePath;
    }

    /**
     * Delete the exported file
     * @throws Exception
     */
    public function delete(): bool
    {
        if ( ! $this->disk->exists($this->filePath)) {
            throw new Exception("File does not exist: {$this->filePath}");
        }

        return $this->disk->delete($this->filePath);
    }

    /**
     * Check if file exists
     */
    public function exists(): bool
    {
        return $this->disk->exists($this->filePath);
    }

    /**
     * Get file size in bytes
     */
    public function getFileSize(): int
    {
        if ( ! $this->exists()) {
            throw new Exception("File does not exist: {$this->filePath}");
        }

        return $this->disk->size($this->filePath);
    }

    /**
     * Get file last modified timestamp
     * @throws Exception
     */
    public function getLastModified(): int
    {
        if ( ! $this->exists()) {
            throw new Exception("File does not exist: {$this->filePath}");
        }

        return $this->disk->lastModified($this->filePath);
    }

    /**
     * Get the media type
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * Get the file path
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Get file content
     */
    protected function getFileContent(): string|false
    {
        if ( ! $this->exists()) {
            return false;
        }

        return $this->disk->get($this->filePath);
    }

    /**
     * Process the downloaded content
     */
    protected function processContent(string $content): string
    {
        $decompressed = gzdecode($content);

        if (false === $decompressed) {
            throw new Exception("Failed to decompress gzip content for {$this->mediaType}");
        }

        return $decompressed;
    }

    /**
     * Download and store the file
     * @throws Exception
     */
    private function downloadAndStore(): string
    {
        $response = $this->downloadFile();
        $content = $this->processContent($response->body());
        $this->storeFile($content);

        return $this->filePath;
    }

    /**
     * Download file from TMDB API
     * @throws ConnectionException
     */
    private function downloadFile(): Response
    {
        $response = Http::timeout(30)
            ->retry(3, 1000)
            ->get($this->url);

        if ( ! $response->successful()) {
            throw new Exception(
                "Failed to download {$this->mediaType} file. HTTP Status: {$response->status()}"
            );
        }

        return $response;
    }

    /**
     * Store content to disk
     */
    private function storeFile(string $content): void
    {
        try {
            $success = $this->disk->put($this->filePath, $content);

            if ( ! $success) {
                throw new Exception("Failed to write {$this->mediaType} file to disk");
            }
        } catch (Exception $e) {
            if ($this->exists()) {
                $this->disk->delete($this->filePath);
            }

            throw new Exception("Failed to store {$this->mediaType} file: " . $e->getMessage(), previous: $e);
        }
    }
}
