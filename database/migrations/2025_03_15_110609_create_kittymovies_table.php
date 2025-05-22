<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kotdnia', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url');
        });

        Schema::create('bazfilmow', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('adult')->default(false);
            $table->string('backdrop_path')->nullable();
            $table->string('original_language', 10)->nullable();
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->float('popularity')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('release_date', 20)->nullable();
            $table->string('title');
            $table->boolean('video')->default(false);
            $table->float('vote_average')->nullable();
            $table->integer('vote_count')->nullable();
            $table->string('genre_ids')->nullable();
        });

        Schema::create('bazfilmowwew', function (Blueprint $table) {
            $table->id();
            $table->boolean('adult')->default(false);
            $table->string('backdrop_path')->nullable();
            $table->json('belongs_to_collection')->nullable();
            $table->float('budget')->nullable();
            $table->json('genres')->nullable(); // pełne obiekty
            $table->string('homepage')->nullable();
            $table->integer('tmdb_id')->nullable(); // id z TMDB
            $table->string('imdb_id')->nullable();
            $table->json('origin_country')->nullable();
            $table->string('original_language', 10)->nullable();
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->float('popularity')->nullable();
            $table->string('poster_path')->nullable();
            $table->json('production_companies')->nullable();
            $table->json('production_countries')->nullable();
            $table->string('release_date', 20)->nullable();
            $table->float('revenue')->nullable();
            $table->integer('runtime')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->string('status')->nullable();
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->boolean('video')->default(false);
            $table->float('vote_average')->nullable();
            $table->integer('vote_count')->nullable();
            $table->string('genre_ids')->nullable(); // zachowaj dla zgodności
            $table->timestamps();
        });

        Schema::create('gatunek', function (Blueprint $table) {
            $table->id();
            $table->string('rodzaj');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kotdnia');
        Schema::dropIfExists('bazfilmow');
        Schema::dropIfExists('bazfilmowwew');
        Schema::dropIfExists('gatunek');
    }
};
