<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('tmdb_id')->default(0);
            $table->string('imdb_id')->nullable()->index();
            $table->boolean('adult')->default(true);
            $table->string('backdrop_path')->nullable();
            $table->string('belongs_to_collection')->nullable();
            $table->unsignedBigInteger('budget')->default(0);
            $table->string('homepage')->nullable();
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->float('popularity')->default(0);
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->unsignedBigInteger('revenue')->default(0);
            $table->unsignedInteger('runtime')->default(0);
            $table->string('status')->nullable();
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->boolean('video')->default(true);
            $table->float('vote_average')->default(0);
            $table->unsignedBigInteger('vote_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
