@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>🎬 Film Indonesia Populer</h2>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                {{-- LOOPING DATA FILM --}}
                @foreach($films as $film)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    
                    <div class="card h-100 shadow-sm border-0" style="background: rgba(255,255,255,0.05);">
                        <div class="overflow-hidden rounded-top">
                            <a href="{{ route('films.show', $film->slug) }}">
                                <img src="{{ $film->poster }}" class="card-img-top" alt="{{ $film->title }}" style="height: 350px; object-fit: cover;">
                            </a>
                        </div>
                        
                        <div class="card-body text-white">
                            <h5 class="card-title fw-bold text-truncate">{{ $film->title }}</h5>
                            <p class="text-muted small mb-2">{{ $film->release_year }} • {{ $film->genre }}</p>
                            
                            <div class="d-flex align-items-center text-warning mb-3">
                                <span>⭐</span>
                                <span class="ms-1 text-white">{{ number_format($film->reviews->avg('point'), 1) }}</span>
                            </div>

                            <a href="{{ route('films.show', $film->slug) }}" class="btn btn-primary w-100 btn-sm">Lihat Detail</a>
                        </div>
                    </div>

                </div>
                @endforeach
                {{-- END LOOPING --}}
            </div>

        </div>
    </div>
</div>
@endsection