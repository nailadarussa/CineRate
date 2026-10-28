<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilmRequest;
use Illuminate\Support\Facades\Auth;

class FilmRequestController extends Controller
{
    // 1. HALAMAN FORM & HISTORY
    public function index()
    {
        // Ambil request milik user yang sedang login
        // Urutkan dari yang terbaru (latest)
        $myRequests = FilmRequest::where('user_id', Auth::id())
                                 ->latest()
                                 ->get();
                                 
        // Kirim variable 'myRequests' ke view
        return view('requests.index', compact('myRequests'));
    }

    // 2. PROSES SIMPAN REQUEST
    public function store(Request $request)
    {   //Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+2),
            'poster_url' => 'nullable|url',
            'note' => 'nullable|string',
        ]);

        // Simpan ke Database
        FilmRequest::create([
            'user_id' => Auth::id(), // ID User yang login
            'title'   => $request->title,
            'year'    => $request->year,
            'poster_url' => $request->poster_url,
            'note'    => $request->note,
            'status'  => 'pending' // Default status
        ]);

        return redirect()->back()->with('success', 'Request berhasil dikirim! Tunggu verifikasi Admin.');
    }
}