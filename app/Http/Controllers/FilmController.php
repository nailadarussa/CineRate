<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;


class FilmController extends Controller
{
    // Halaman Daftar Semua Film (/films)
    public function index(Request $request)
    {
        // Fitur Search khusus halaman ini
        $query = Film::latest();

        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Ambil 12 film per halaman (biar rapi 4 baris x 3 kolom atau variasi lain)
        // with('reviews') = Eager loading biar ringan (Tips Optimasi tadi)
        $films = $query->with('reviews')->paginate(12); 

        return view('films.index', compact('films'));
    }
    
    public function welcome()
    {
        // 1. CAROUSEL: 3 Film Terbaru yang punya Banner
        $heroFilms = Film::whereNotNull('banner')->latest()->take(3)->get();
        // Kalau ga ada banner, ambil random aja
        if($heroFilms->isEmpty()) { $heroFilms = Film::latest()->take(3)->get(); }

        // 2. LATEST: 10 Film berdasar waktu upload
        $latestFilms = Film::latest()->take(10)->get();

        // 3. POPULAR: Film yang dicentang admin sebagai 'is_popular'
        $popularFilms = Film::where('is_popular', true)->latest()->take(10)->get();

        return view('welcome', compact('heroFilms', 'latestFilms', 'popularFilms'));
    }
    
    // Function untuk menampilkan detail 1 film
    public function show($slug)
    {
        // 2. Cari film berdasarkan slug-nya (misal: 'agak-laen')
        // firstOrFail() artinya: Cari datanya, kalau gak ketemu tampilkan 404 Not Found.
        $film = Film::where('slug', $slug)->firstOrFail();

        // 3. Kirim ke view detail
        return view('films.show', compact('film'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('query');

        // Cari film yang judulnya MIRIP dengan keyword
        $films = Film::where('title', 'LIKE', "%{$keyword}%")->get();

        return view('films.search', compact('films', 'keyword'));
    }
}