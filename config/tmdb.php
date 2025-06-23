<?php

return [
    /*
    |--------------------------------------------------------------------------
    | TMDB Export URLs
    |--------------------------------------------------------------------------
    |
    | These URLs are used to download daily export files from TMDB.
    | The %s placeholder will be replaced with the date in m_d_Y format.
    |
    */

    'movie_export_url' => env('TMDB_MOVIE_EXPORT_URL', 'http://files.tmdb.org/p/exports/movie_ids_%s.json.gz'),

    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configure where TMDB export files should be stored.
    |
    */

    'storage_disk' => env('TMDB_STORAGE_DISK', 'tmdb_files'),

    /*
    |--------------------------------------------------------------------------
    | Download Configuration
    |--------------------------------------------------------------------------
    |
    | Configure download behavior for TMDB exports.
    |
    */

    'download_timeout' => env('TMDB_DOWNLOAD_TIMEOUT', 30),
    'download_retries' => env('TMDB_DOWNLOAD_RETRIES', 3),
    'retry_delay' => env('TMDB_RETRY_DELAY', 1000), // milliseconds
];


