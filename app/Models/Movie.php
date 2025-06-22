<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Movie extends Model
{
    use SoftDeletes;

    protected $table = 'movies';

    protected $fillable = [
        'tmdb_id',
        'imdb_id',
        'adult',
        'backdrop_path',
        'belongs_to_collection',
        'budget',
        'homepage',
        'original_language',
        'original_title',
        'overview',
        'popularity',
        'poster_path',
        'release_date',
        'revenue',
        'runtime',
        'status',
        'tagline',
        'title',
        'video',
        'vote_average',
        'vote_count',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'datetime:Y-m-d',
            'adult' => 'boolean',
            'video' => 'boolean',
            'vote_average' => 'float',
            'popularity' => 'float',
            'budget' => 'integer',
            'revenue' => 'integer',
            'vote_count' => 'integer',
            'runtime' => 'integer',
        ];
    }
}
