<?php

declare(strict_types=1);

namespace App\Exporters\TMDB;

use InvalidArgumentException;

final class TmdbExporterFactory
{
    private const EXPORTERS = [
        'movie' => MovieExporter::class,
    ];

    public static function create(string $type, string $baseUrl): AbstractTmdbExporter
    {
        if ( ! isset(self::EXPORTERS[$type])) {
            throw new InvalidArgumentException("Unsupported exporter type: {$type}");
        }

        $exporterClass = self::EXPORTERS[$type];
        return new $exporterClass($baseUrl);
    }

    public static function getSupportedTypes(): array
    {
        return array_keys(self::EXPORTERS);
    }
}
