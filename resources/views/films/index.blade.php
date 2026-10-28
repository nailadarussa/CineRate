@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">Jelajahi Film Indonesia</h2>
        <p class="text-muted">Temukan rating dan ulasan film favoritmu di sini.</p>
        
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <form action="{{ route('films.index') }}" method="GET">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                        <input type="text" name="q" class="form-control border-0 ps-4 py-2" 
                               placeholder="Cari judul film..." value="{{ request('q') }}">
                        <button class="btn btn-white border-0 text-muted pe-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
        @forelse($films as $film)
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
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">
                <i class="bi bi-film fs-1 d-block mb-3"></i>
                <p>Yah, film yang kamu cari tidak ditemukan.</p>
                <a href="{{ route('films.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">Reset Pencarian</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $films->links() }} 
    </div>

</div>

<style>
    .page-item.active .page-link {
        background-color: var(--cr-primary);
        border-color: var(--cr-primary);
    }
    .page-link { color: var(--cr-primary); }
</style>
@endsection