@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <div class="mb-5">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-search me-2 text-muted"></i> 
            Hasil Pencarian: "<span class="text-primary">{{ $keyword }}</span>"
        </h3>
        <p class="text-muted">Ditemukan {{ $films->count() }} film</p>
    </div>

    @if($films->count() > 0)
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-4">
            @foreach($films as $film)
            <div class="col">
                <div class="movie-card shadow-sm h-100 position-relative">
                    <a href="{{ route('films.show', $film->slug) }}" class="text-decoration-none text-dark d-block h-100">
                        
                        <div class="rating-badge">
                            <i class="bi bi-star-fill text-warning me-1"></i> 
                            {{ number_format($film->reviews->avg('point'), 1) }}
                        </div>

                        <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                             alt="{{ $film->title }}">
                        
                        <div class="p-3">
                            <h6 class="fw-bold text-truncate mb-1" style="font-size: 0.95rem;">{{ $film->title }}</h6>
                            <small class="text-muted d-block">{{ $film->release_year }}</small>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3 text-muted opacity-50">
                <i class="bi bi-emoji-frown fs-1"></i>
            </div>
            <h4 class="fw-bold text-muted">Yah, filmnya gak ketemu.</h4>
            <p class="text-muted small">Coba cari dengan kata kunci lain atau cek ejaanmu.</p>
            <a href="{{ route('films.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 mt-2">
                Lihat Semua Film
            </a>
        </div>
    @endif

</div>
@endsection