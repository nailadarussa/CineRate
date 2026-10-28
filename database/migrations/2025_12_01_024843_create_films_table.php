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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            
            // Data Utama Film
            $table->string('title');            // Judul Film (misal: Agak Laen)
            $table->string('slug')->unique();   // Judul versi URL (misal: agak-laen)
            $table->text('synopsis');           // Sinopsis cerita (Pakai Text krn panjang)
            $table->string('poster')->nullable(); // Foto Poster (Boleh kosong/nullable)
            
            // Data Tambahan
            $table->year('release_year');       // Tahun Rilis (2024)
            $table->string('director');         // Sutradara
            $table->string('genre');            // Genre (Horror, Komedi)
            
            $table->timestamps(); // Otomatis buat kolom created_at & updated_at
        });
    }
};