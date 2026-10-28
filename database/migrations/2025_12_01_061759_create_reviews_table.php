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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // KUNCI ASING (Foreign Keys)
            // Menyimpan ID User (hapus review jika user dihapus)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Menyimpan ID Film (hapus review jika film dihapus)
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            
            // Data Review
            $table->text('content');        // Isi komentar
            $table->integer('point');       // Bintang (1 - 5)
            
            $table->timestamps();
        });
    }
};
