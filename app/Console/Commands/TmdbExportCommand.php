<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exporters\TMDB\TmdbExporterFactory;
use Exception;
use Illuminate\Console\Command;

final class TmdbExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'tmdb:export
                            {type : The type of export (movie)}
                            {--content : Get file content instead of just path}
                            {--stats : Show statistics about the exported data}
                            {--force : Force re-download even if file exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export TMDB data from json files and store them in the filesystem';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');

        if ( ! in_array($type, TmdbExporterFactory::getSupportedTypes())) {
            $this->error("Unsupported type: {$type}");
            $this->info('Supported types: ' . implode(', ', TmdbExporterFactory::getSupportedTypes()));

            $this->fail('Invalid type specified.');
        }

        try {
            $baseUrl = config("tmdb.{$type}_export_url");
            $exporter = TmdbExporterFactory::create($type, $baseUrl);


            if ($this->option('force') && $exporter->exists()) {
                $exporter->delete();
                $this->info("Deleted existing {$type} export file");
            }

            $this->info("Starting {$type} export...");

            $result = $exporter->export($this->option('content'));

            if ($this->option('content')) {
                $this->info("Export completed. Content length: " . mb_strlen($result) . " characters");
            } else {
                $this->info("Export completed. File saved to: {$result}");
            }

            if ($this->option('stats')) {
                $this->showStats($exporter, $type);
            }

            return 0;

        } catch (Exception $e) {
            $this->error("Export failed: " . $e->getMessage());
            return 1;
        }
    }

    /* helper function to show statistics based on the type of export  todo remove it */
    private function showStats($exporter, string $type): void
    {
        $this->info("\n=== Export Statistics ===");

        try {
            $stats = match ($type) {
                'movie' => $exporter->getMovieStats(),
                'tv_show' => $exporter->getTvShowStats(),
                'person' => $exporter->getPersonStats(),
                default => [],
            };

            $rows = match ($type) {
                'movie' => [
                    ['Total Movies', $stats['total_movies'] ?? 'N/A'],
                    ['File Size (MB)', $stats['file_size_mb'] ?? 'N/A'],
                    ['Last Updated', $stats['last_updated'] ?? 'N/A'],
                ],
                'tv_show' => [
                    ['Total TV Shows', $stats['total_tv_shows'] ?? 'N/A'],
                    ['File Size (MB)', $stats['file_size_mb'] ?? 'N/A'],
                    ['Last Updated', $stats['last_updated'] ?? 'N/A'],
                ],
                'person' => [
                    ['Total People', $stats['total_people'] ?? 'N/A'],
                    ['File Size (MB)', $stats['file_size_mb'] ?? 'N/A'],
                    ['Last Updated', $stats['last_updated'] ?? 'N/A'],
                ],
                default => [['Error', 'Unsupported type']],
            };

            $this->table(['Metric', 'Value'], $rows);

        } catch (Exception $e) {
            $this->warn("Could not generate statistics: " . $e->getMessage());
        }
    }
}
