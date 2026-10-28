@extends('layouts.admin')

@section('content')
<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary">Edit Data Film: {{ $film->title }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.films.update', $film->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT') <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Film</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $film->title) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tahun Rilis</label>
                            <input type="number" name="release_year" class="form-control" value="{{ old('release_year', $film->release_year) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Durasi</label>
                            <input type="text" name="duration" class="form-control" placeholder="Contoh: 1j 47m" value="{{ old('duration', $film->duration) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Genre</label>
                            <input type="text" name="genre" class="form-control" value="{{ old('genre', $film->genre) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sutradara</label>
                        <input type="text" name="director" class="form-control" value="{{ old('director', $film->director) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pemain Utama (Cast)</label>
                        <input type="text" name="cast" class="form-control" value="{{ old('cast', $film->cast) }}" required>
                        <div class="form-text">Pisahkan dengan koma. Contoh: Dian Sastro, Nicholas Saputra</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sinopsis</label>
                        <textarea name="synopsis" class="form-control" rows="5" required>{{ old('synopsis', $film->synopsis) }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center">
                            <label class="form-label fw-bold mb-3">Poster Film</label>
                            
                            <div class="mb-3">
                                <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                                     alt="Poster Lama" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="max-height: 300px;">
                                <p class="text-muted small mt-2">Poster Saat Ini</p>
                            </div>

                            <input type="file" name="poster" class="form-control mb-2" accept="image/*">
                            <small class="text-danger d-block text-start">*Biarkan kosong jika tidak ingin mengubah poster.</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3 mt-4">
                    <label class="form-label fw-bold">Banner / Backdrop (Landscape)</label>
                    
                    @if($film->banner)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $film->banner) }}" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    @endif

                    <input type="file" name="banner" class="form-control" accept="image/*">
                    <small class="text-muted">Disarankan ukuran 1920x600 px.</small>
                </div>                
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="is_popular" class="form-check-input" id="isPop" value="1" 
                        {{ $film->is_popular ? 'checked' : '' }}>    
                <label class="form-check-label fw-bold" for="isPop">Tampilkan di "Film Populer"?</label>
                <div class="form-text">Jika dicentang, film ini akan muncul di slider paling bawah halaman depan.</div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.films.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-warning fw-bold px-4">Update Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection