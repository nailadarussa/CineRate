<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film; // <--- JANGAN LUPA INI!

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        // Film 1: Agak Laen
        Film::create([
            'title' => 'Agak Laen',
            'slug' => 'agak-laen',
            'synopsis' => 'Demi mengejar mimpi mengubah nasib, empat sekawan penjaga rumah hantu di pasar malam mencari cara baru menakuti pengunjung agar selamat dari kebangkrutan.',
            'poster' => 'https://image.tmdb.org/t/p/original/n2C01z0vj66jU1q3z3yE6l.jpg', // Link gambar dummy
            'release_year' => 2024,
            'director' => 'Muhadkly Acho',
            'genre' => 'Comedy, Horror'
        ]);

        // Film 2: The Raid
        Film::create([
            'title' => 'The Raid',
            'slug' => 'the-raid',
            'synopsis' => 'Sebuah tim S.W.A.T. terjebak di dalam gedung apartemen yang dikuasai oleh penjahat kejam dan pasukannya.',
            'poster' => 'https://image.tmdb.org/t/p/original/57P8FwFj7d26h7a7.jpg',
            'release_year' => 2011,
            'director' => 'Gareth Evans',
            'genre' => 'Action, Thriller'
        ]);

        // Film 3: Laskar Pelangi
        Film::create([
            'title' => 'Laskar Pelangi',
            'slug' => 'laskar-pelangi',
            'synopsis' => 'Perjuangan dua guru muslim inspiratif dan 10 muridnya di sebuah pulau kecil di Belitung.',
            'poster' => 'https://image.tmdb.org/t/p/original/k1l9j5z2.jpg',
            'release_year' => 2008,
            'director' => 'Riri Riza',
            'genre' => 'Drama'
        ]);
    }
}