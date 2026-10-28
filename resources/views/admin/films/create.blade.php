@extends('layouts.admin')

@section('content')
<div class="card shadow border-0">
    <div class="card-header bg-white fw-bold">➕ Input Data Film</div>
    <div class="card-body">
        <form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Film</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun</label>
                        <input type="number" name="release_year" class="form-control" placeholder="2024" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Durasi</label>
                        <input type="text" name="duration" class="form-control" placeholder="1j 45m" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Poster (Upload)</label>
                    <input type="file" name="poster" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, PNG. Max: 2MB.</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Banner / Backdrop (Landscape)</label>
                    <input type="file" name="banner" class="form-control" accept="image/*" required>
                    <small class="text-muted">Disarankan ukuran 1920x600 px.</small>
                </div>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="is_popular" class="form-check-input" id="isPop" value="1">
                <label class="form-check-label fw-bold" for="isPop">Tampilkan di "Film Populer"?</label>
                <div class="form-text">Jika dicentang, film ini akan muncul di slider paling bawah halaman depan.</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sutradara</label>
                    <input type="text" name="director" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Genre</label>
                    <input type="text" name="genre" class="form-control" placeholder="Drama, Romance" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Pemain Utama (Cast)</label>
                <input type="text" name="cast" class="form-control" placeholder="Dian Sastro, Nicholas Saputra..." required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sinopsis</label>
                <textarea name="synopsis" class="form-control" rows="4" required></textarea>
            </div>

            <button class="btn btn-primary w-100 fw-bold">Simpan Film</button>
        </form>
    </div>
</div>
@endsection