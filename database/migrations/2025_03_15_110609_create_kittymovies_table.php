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
            $table->string('name');
            $table->string('gatunek');
            $table->float('srednia');
            $table->integer('ocena');
            $table->string('dodanoprzez');
            $table->year('rokpremiery');
            $table->text('komentarz')->nullable();
            $table->string('image');
        });

        Schema::create('gatunek', function (Blueprint $table) {
            $table->id();
            $table->string('rodzaj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kotdnia');
        Schema::dropIfExists('bazfilmow');
        Schema::dropIfExists('gatunek');
    }
};
