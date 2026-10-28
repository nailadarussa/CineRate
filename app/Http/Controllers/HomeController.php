<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film; // <--- Pastikan ini ada

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. DATA CAROUSEL (Ini yang bikin error kemarin karena kurang)
        $heroFilms = Film::latest()->take(3)->get();

        // 2. DATA GRID FILM
        $films = Film::latest()->take(8)->get();

        // 3. Kirim DUANYA ke view
        return view('welcome', compact('films', 'heroFilms'));
    }
}