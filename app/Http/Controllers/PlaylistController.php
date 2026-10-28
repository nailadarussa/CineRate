<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    // Halaman Playlist Saya
    public function index()
    {
        $playlists = Playlist::where('user_id', Auth::id())->latest()->get();
        return view('playlists.index', compact('playlists'));
    }

    // Simpan Playlist Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Playlist::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Playlist berhasil dibuat!');
    }

    // Lihat Detail Playlist (Isi filmnya apa aja)
    public function show($id)
    {
        $playlist = Playlist::where('user_id', Auth::id())->findOrFail($id);

        // Pagination 12 film per halaman
        $films = $playlist->films()->paginate(12);

        return view('playlists.show', compact('playlist', 'films'));
    }

    // Masukkan Film ke Playlist
    public function toggleFilm(Request $request, $film_id)
    {
        $request->validate(['playlist_id' => 'required|exists:playlists,id']);

        $playlist = Playlist::where('user_id', Auth::id())
                            ->findOrFail($request->playlist_id);

        // LOGIC TOGGLE: Kalau ada -> Hapus. Kalau ga ada -> Simpan.
        if ($playlist->films()->where('film_id', $film_id)->exists()) {
            $playlist->films()->detach($film_id);
            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari Watchlist']);
        } else {
            $playlist->films()->attach($film_id);
            return response()->json(['status' => 'added', 'message' => 'Disimpan ke Watchlist']);
        }
    }

    // UPDATE WATCHLIST (Nama & Deskripsi)
    public function update(Request $request, $id)
    {
        $playlist = Playlist::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $playlist->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Informasi watchlist berhasil diperbarui!');
    }
    
    // HAPUS FILM DARI WATCHLIST (Versi AJAX/JSON)
    public function removeFilm($playlist_id, $film_id)
    {
        // 1. Cari Playlist milik user yang login
        $playlist = Playlist::where('user_id', Auth::id())->findOrFail($playlist_id);

        // 2. Hapus film dari playlist (detach)
        $playlist->films()->detach($film_id);
        
        // 3. PENTING: Return JSON, JANGAN 'back()' atau 'redirect()'
        return response()->json([
            'status' => 'success', 
            'message' => 'Film berhasil dihapus'
        ]);
    }
}