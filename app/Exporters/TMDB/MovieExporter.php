<?php

declare(strict_types=1);

namespace App\Exporters\TMDB;

use Exception;

final readonly class MovieExporter extends AbstractTmdbExporter
{
    public function __construct(string $baseUrl)
    {
        parent::__construct($baseUrl, 'movie');
    }

    /**
     * Get movie-specific statistics from the exported data
     * @throws Exception
     */
    public function getMovieStats(): array
    {
        $content = $this->getFileContent();

        if ( ! $content) {
            return [];
        }

        $lines = explode("\n", mb_trim($content));
        $totalMovies = count($lines);

        $sampleMovies = array_slice($lines, 0, 5);
        $parsedSamples = array_map(fn ($line) => json_decode($line, true), $sampleMovies);

        return [
            'total_movies' => $totalMovies,
            'sample_data' => array_filter($parsedSamples),
            'file_size_mb' => round($this->getFileSize() / 1024 / 1024, 2),
            'last_updated' => date('Y-m-d H:i:s', $this->getLastModified())
        ];
    }
}
