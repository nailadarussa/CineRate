<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FilmRequest;

class AdminRequestController extends Controller
{
    // 1. Tampilkan Semua Request (Yang statusnya Pending ada di atas)
    public function index()
    {
        $requests = FilmRequest::with('user') // Ambil data user penanya sekalian
                             ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')") // Pending duluan
                             ->latest()
                             ->get();

        return view('admin.requests', compact('requests'));
    }

    public function approve($id)
    {
        $req = FilmRequest::findOrFail($id);

        // Jangan langsung update status!
        // Oper Admin ke halaman 'Create Film' sambil bawa data Judul & ID Request
        return redirect()->route('admin.films.create', [
            'title' => $req->title,
            'request_id' => $req->id
        ]);
    }

    // 3. Aksi Reject (Tolak)
    public function reject($id)
    {
        $req = FilmRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Request ditolak. ❌');
    }
}