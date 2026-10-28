<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilmsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Str;

class AdminFilmController extends Controller
{
    public function index()
    {
        // Ambil data film sekalian data review (kalau mau nampilin jumlah review di tabel admin)
        $films = Film::with('reviews')->latest()->get(); 
        return view('admin.films.index', compact('films'));
    }

    // 2. FORM TAMBAH FILM
    public function create()
    {
        return view('admin.films.create');
    }

        // 3. PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'poster' => 'required|image|max:2048',
            'banner' => 'nullable|image|max:4096',
            'release_year' => 'required|integer',
            'duration' => 'required',
            'genre' => 'required',
            'director' => 'required',
            'cast' => 'required',
            'synopsis' => 'required',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');
        
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        Film::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'poster' => $posterPath,
            'banner' => $bannerPath,
            'is_popular' => $request->has('is_popular'), // <--- INI KUNCINYA!
            'release_year' => $request->release_year,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'cast' => $request->cast,
            'synopsis' => $request->synopsis,
        ]);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    // 4. HAPUS FILM
    public function destroy($id)
    {
        Film::findOrFail($id)->delete();
        return back()->with('success', 'Film berhasil dihapus.');
    }

    // TAMPILKAN FORM EDIT
    public function edit($id)
    {
        $film = Film::findOrFail($id);
        return view('admin.films.edit', compact('film'));
    }

    // PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'poster' => 'nullable|image|max:2048', // Nullable kalau edit
            'banner' => 'nullable|image|max:4096',
            'release_year' => 'required|integer',
            'duration' => 'required',
            'synopsis' => 'required',
        ]);

        // Cek Gambar
        if ($request->hasFile('poster')) {
            $film->poster = $request->file('poster')->store('posters', 'public');
        }
        if ($request->hasFile('banner')) {
            $film->banner = $request->file('banner')->store('banners', 'public');
        }

        // Update Data
        $film->update([
            'title' => $request->title,
            'is_popular' => $request->has('is_popular'), // <--- JANGAN LUPA INI DI UPDATE JUGA
            'release_year' => $request->release_year,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'cast' => $request->cast,
            'synopsis' => $request->synopsis,
        ]);
        
        $film->save(); // Simpan perubahan gambar (jika ada)

        return redirect()->route('admin.films.index')->with('success', 'Film diperbarui!');
    }

    // EXPORT PDF
    public function exportPdf()
    {
        // Ambil semua data film
        $films = Film::all();

        // Load view yang tadi kita buat & kirim datanya
        $pdf = Pdf::loadView('admin.films.export_pdf', compact('films'));

        // Download file dengan nama 'laporan_film.pdf'
        return $pdf->download('laporan_film.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new FilmsExport, 'data_film.xlsx');
    }
}