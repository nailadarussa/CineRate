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
        Schema::create('film_playlist', function (Blueprint $table) {
            $table->id();
            // Hubungkan ID Playlist dan ID Film
            $table->foreignId('playlist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('film_id')->constrained()->cascadeOnDelete();
            
            // Mencegah duplikasi (Satu film gak boleh masuk 2x di playlist yang sama)
            $table->unique(['playlist_id', 'film_id']); 
        });
    }
};
