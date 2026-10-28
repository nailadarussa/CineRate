<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Fungsi untuk menyimpan review baru
    public function store(Request $request, $film_slug)
    {
        // 1. Validasi Input (Wajib pilih bintang & isi komentar)
        $request->validate([
            'point'   => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:3|max:500' // Minimal 3 huruf, maksimal 500
        ]);

        // 2. Cari Filmnya
        $film = Film::where('slug', $film_slug)->firstOrFail();

        // 3. Simpan ke Database (Pakai updateOrCreate biar user cuma bisa review 1x per film)
        // Jadi kalau dia review lagi, review lamanya tertimpa (update).
        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'film_id' => $film->id
            ],
            [
                'point'   => $request->point,
                'content' => $request->content
            ]
        );

        return redirect()->back()->with('success', 'Review berhasil dikirim! ⭐');
    }

    // 1. HAPUS REVIEW
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Validasi Pemilik
        if ($review->user_id != Auth::id() && Auth::user()->role != 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $review->delete();

        // Return JSON agar JS bisa menghapus elemen HTML tanpa refresh
        return response()->json(['status' => 'success']);
    }

    public function toggleLike($id)
    {
        $review = Review::findOrFail($id);
        
        // Toggle Like (Kalau ada hapus, kalau ga ada tambah)
        $review->likes()->toggle(Auth::id());

        // Return Data JSON untuk JavaScript
        return response()->json([
            'status' => 'success',
            'liked' => $review->likes->contains(Auth::id()), // True kalau user nge-like
            'count' => $review->likes()->count() // Jumlah like terbaru
        ]);
    }
}