@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <section id="hero-carousel" class="mb-5 shadow rounded overflow-hidden position-relative">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($heroFilms as $index => $hero)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="height: 500px;">
                        <img src="{{ $hero->banner ? asset('storage/'.$hero->banner) : (Str::startsWith($hero->poster, 'http') ? $hero->poster : asset('storage/'.$hero->poster)) }}" 
                             class="d-block w-100 h-100" style="object-fit: cover;">
                        
                        <div class="carousel-caption d-block pb-5 text-start text-md-start px-2 px-md-5">
                            <div class="mb-2">
                                <span class="badge bg-warning text-dark fw-bold fs-6 shadow-sm">
                                    ★ {{ number_format($hero->reviews->avg('point'), 1) }}
                                </span>
                            </div>
                            <h2 class="fw-bold display-4 mb-2 text-shadow text-white">{{ $hero->title }}</h2>
                            <p class="fs-5 text-white-50 mb-4 d-none d-md-block text-shadow" style="max-width: 700px;">
                                {{ Str::limit($hero->synopsis, 150) }}
                            </p>
                            <a href="{{ route('films.show', $hero->slug) }}" class="btn btn-outline-light fw-bold px-4 py-2 shadow-sm">
                                LIHAT DETAIL
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev custom-arrow" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next custom-arrow" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <section class="my-5">
        <h3 class="fw-bold mb-4 text-dark border-start border-4 border-warning ps-3">Temukan Film Terbaru</h3>
        
        <div class="movie-slider">
            @foreach($latestFilms as $film)
            <div class="movie-item">
                <div class="movie-card">
                    <a href="{{ route('films.show', $film->slug) }}" class="text-decoration-none text-dark h-100 d-flex flex-column">
                        <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                             alt="{{ $film->title }}">
                        
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-1">{{ $film->title }}</h6>
                            <p class="small text-muted mb-0 d-flex justify-content-between align-items-center">
                                <span>{{ $film->release_year }}</span>
                                <span class="text-warning fw-bold">★ {{ number_format($film->reviews->avg('point'), 1) }}</span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section id="core-features" class="mb-5 pt-5 pb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6">Kenapa CineRate?</h2>
            <p class="text-muted lead">Platform pecinta film Indonesia nomor satu.</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-3 col-md-6">
                <div class="feature-card card-track">
                    <div class="icon-square">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Track Film</h5>
                    <p class="text-muted small">Catat setiap film Indonesia yang sudah kamu tonton agar tidak lupa.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card card-rate">
                    <div class="icon-square">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Beri Nilai</h5>
                    <p class="text-muted small">Jadilah kritikus! Beri bintang 1-5 dan tulis ulasan jujurmu.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card card-list">
                    <div class="icon-square">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Suka & Koleksi</h5>
                    <p class="text-muted small">Simpan film favorit ke dalam Playlist pribadi yang keren.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card-request-dark">
                    <div class="icon-square">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Film Belum Ada?</h5>
                    <p class="text-white-50 small mb-4">Database kurang lengkap? Bantu kami dengan request film baru.</p>
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-light fw-bold rounded-pill px-4 btn-sm">
                        Request Sekarang
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="my-5">
        <h3 class="fw-bold mb-4 text-dark border-start border-4 border-warning ps-3">Film Populer Sepanjang Masa</h3>
        
        <div class="movie-slider">
            @if($popularFilms->count() > 0)
                @foreach($popularFilms as $film)
                <div class="movie-item">
                    <div class="movie-card">
                        <a href="{{ route('films.show', $film->slug) }}" class="text-decoration-none text-dark h-100 d-flex flex-column">
                            <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                                 alt="{{ $film->title }}">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-1">{{ $film->title }}</h6>
                                <p class="small text-muted mb-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $film->release_year }}</span>
                                    <span class="text-warning fw-bold">★ {{ number_format($film->reviews->avg('point'), 1) }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5 border rounded bg-white">
                    <p class="text-muted mb-0 fst-italic">Belum ada film populer.</p>
                </div>
            @endif
        </div>
    </section>

</div>

<style>
    .custom-arrow { opacity: 0; transition: 0.3s; width: 5%; }
    #hero-carousel:hover .custom-arrow { opacity: 1; }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 25px; background-size: 50%;
    }
</style>
@endsection