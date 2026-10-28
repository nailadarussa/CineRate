@extends('layouts.app')

@section('content')

<style>
    /* 1. FORCE DARK MODE VARIABLES */
    :root {
        --cr-bg-light: #14181c !important;
        --cr-text-dark: #e0e6ed !important;
        --cr-primary: #1a1b1b !important;
    }

    body { background-color: #14181c !important; color: #e0e6ed !important; }
    .navbar { background-color: #161b22 !important; border-bottom: 1px solid #2c3036; }
    .navbar-brand, .nav-link { color: #fff !important; }

    /* 2. HEADER BANNER CINEMATIC */
    .film-header {
        position: relative;
        height: 550px;
        background-size: cover;
        background-position: center;
        margin-top: -1.5rem;
    }
    
    .film-header::after {
        content: ''; 
        position: absolute; 
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(20,24,28,0.8) 80%, #14181c 100%);
        z-index: 1;
    }
    
    .header-content {
        position: relative;
        z-index: 2;
    }

    /* 3. KOMPONEN UI */
    .rating-box {
        background: #1e2329; border: 1px solid #2c3440; border-radius: 12px;
        padding: 20px; text-align: center;
    }
    .info-card {
        background: #1c2128; border: 1px solid #333; border-radius: 8px;
        padding: 15px; height: 100%;
    }
    .form-dark {
        background-color: #0d1117; border: 1px solid #30363d; color: #fff;
    }
    .form-dark:focus {
        background-color: #0d1117; color: #fff; border-color: #41b883; box-shadow: none;
    }
    
    /* PERBAIKAN WARNA TEKS (Biar gak nabrak) */
    ::placeholder { color: #8b949e !important; opacity: 1; }
    .text-bright { color: #fff !important; }
    .text-grey { color: #aeb5bc !important; } /* Abu terang */
    .text-content { color: #d1d5db !important; line-height: 1.6; }

    /* 4. STAR RATING INTERAKTIF */
    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        gap: 5px;
    }
    .star-rating input { display: none; }
    .star-rating label {
        font-size: 1.8rem; color: #444; cursor: pointer; transition: 0.2s;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }
</style>

<header class="film-header" style="background-image: url('{{ $film->banner ? asset('storage/'.$film->banner) : asset('storage/'.$film->poster) }}');">
    <div class="container h-100 d-flex align-items-center justify-content-center position-relative" style="z-index: 2;">
        <div class="text-center">
            <h1 class="display-3 fw-bold text-bright text-uppercase" style="text-shadow: 0 4px 15px rgba(0,0,0,0.9);">
                {{ $film->title }}
            </h1>
            <p class="fs-4 text-white-50">
                {{ $film->release_year }} <span class="mx-2">•</span> {{ $film->genre }}
            </p>
        </div>
    </div>
</header>

<div class="container pb-5" style="margin-top: -100px; position: relative; z-index: 5;">
    <div class="row">
        
        <div class="col-lg-3 mb-5">
            <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                 class="w-100 rounded shadow-lg border border-secondary" style="border-width: 1px !important;">
            
            <div class="rating-box mt-3 shadow-sm">
                <h6 class="text-grey text-uppercase small fw-bold mb-1">CineRate Score</h6>
                <div class="display-3 fw-bold text-success">{{ number_format($film->reviews->avg('point'), 1) }}</div>
                <small class="text-grey">{{ $film->reviews->count() }} Pengguna</small>
            </div>

            @auth
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-light py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#addToPlaylistModal">
                        <i class="bi bi-bookmark-plus me-2"></i> Simpan ke List
                    </button>
                </div>
            @endauth
        </div>

        <div class="col-lg-9 ps-lg-5 pt-4">
            
            <div class="mb-5">
                <h4 class="text-bright border-bottom border-secondary pb-2 mb-3">Sinopsis</h4>
                <p class="fs-5 lh-lg text-content">{{ $film->synopsis }}</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="info-card">
                        <small class="text-grey fw-bold text-uppercase">Sutradara</small>
                        <p class="fs-5 text-bright mb-0">{{ $film->director }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <small class="text-grey fw-bold text-uppercase">Pemain Utama</small>
                        <p class="fs-5 text-bright mb-0">{{ $film->cast ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <h4 class="text-bright border-bottom border-secondary pb-2 mb-4 d-flex justify-content-between align-items-center">
                Review & Komentar 
                <span class="badge bg-secondary">{{ $film->reviews->count() }}</span>
            </h4>

            @auth
                @php $userReview = $film->reviews->where('user_id', Auth::id())->first(); @endphp

                <div class="card border-0 mb-5 shadow-sm" style="background: #1e2329; border-radius: 12px;">
                    <div class="card-body p-4">
                        
                        @if($userReview)
                            <div id="my-review-display">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h5 class="text-white fw-bold mb-0">Review Kamu</h5>
                                            <span class="badge bg-primary small" style="font-size: 0.65rem;">YOU</span>
                                        </div>
                                    </div>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-icon-only p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5 text-grey"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" onclick="toggleEditMode()">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger" onclick="confirmDeleteReview({{ $userReview->id }}, 'self')">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-3 text-warning fs-5">
                                    @for($i=0; $i<$userReview->point; $i++) <i class="bi bi-star-fill"></i> @endfor
                                    @for($i=$userReview->point; $i<5; $i++) <i class="bi bi-star text-secondary"></i> @endfor
                                </div>
                                <p class="text-content fst-italic fs-5">"{{ $userReview->content }}"</p>

                                <div class="mt-3 border-top border-secondary pt-2">
                                    <button class="btn btn-sm p-0 border-0 d-flex align-items-center gap-2 bg-transparent" 
                                            onclick="toggleLike({{ $userReview->id }})" 
                                            id="like-btn-{{ $userReview->id }}">
                                        
                                        <i class="bi {{ $userReview->likes->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-muted' }}" 
                                           id="like-icon-{{ $userReview->id }}" style="font-size: 1.1rem;"></i>
                                        
                                        <span class="text-grey small fw-bold" id="like-count-{{ $userReview->id }}">
                                            {{ $userReview->likes->count() }} {{ $userReview->likes->count() == 1 ? 'Like' : 'Likes' }}
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div id="my-review-form" style="display: none;">
                                <form action="{{ route('reviews.store', $film->slug) }}" method="POST">
                                    @csrf
                                    <h6 class="text-bright mb-3 fw-bold">Edit Review Kamu</h6>
                                    
                                    <div class="mb-3">
                                        <div class="star-rating">
                                            @for($i=5; $i>=1; $i--)
                                                <input type="radio" id="e-star{{$i}}" name="point" value="{{$i}}" {{ $userReview->point == $i ? 'checked' : '' }} required />
                                                <label for="e-star{{$i}}"><i class="bi bi-star-fill"></i></label>
                                            @endfor
                                        </div>
                                    </div>

                                    <textarea name="content" class="form-control form-dark mb-3" rows="3" required>{{ $userReview->content }}</textarea>
                                    
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEditMode()">Batal</button>
                                        <button type="submit" class="btn btn-warning btn-sm fw-bold">Update Review</button>
                                    </div>
                                </form>
                            </div>

                        @else
                            <form action="{{ route('reviews.store', $film->slug) }}" method="POST">
                                @csrf
                                <div class="d-flex align-items-start gap-3">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="w-100">
                                        <h6 class="text-bright mb-2 fw-bold">Tulis Review Kamu</h6>
                                        
                                        <div class="mb-2">
                                            <div class="star-rating">
                                                @for($i=5; $i>=1; $i--)
                                                    <input type="radio" id="new-star{{$i}}" name="point" value="{{$i}}" required />
                                                    <label for="new-star{{$i}}"><i class="bi bi-star-fill"></i></label>
                                                @endfor
                                            </div>
                                        </div>

                                        <textarea name="content" class="form-control form-dark mb-3" rows="3" placeholder="Bagaimana pendapatmu tentang film ini?" required></textarea>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success fw-bold px-4">Kirim Review</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-dark border-secondary d-flex justify-content-between align-items-center mb-5">
                    <span class="text-white-50">Ingin menulis review?</span>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-4">Login Sekarang</a>
                </div>
            @endauth

            <div class="review-list">
                @forelse($film->reviews->where('user_id', '!=', Auth::id())->sortByDesc('created_at') as $review)
                    <div class="d-flex gap-3 mb-4 pb-4 border-bottom border-secondary" id="review-item-{{ $review->id }}">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-dark border border-secondary text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                        </div>
                        
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-bright mb-0">{{ $review->user->name }}</h6>
                                <span class="text-grey small">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="text-warning small mb-2">
                                @for($i=0; $i<$review->point; $i++) <i class="bi bi-star-fill"></i> @endfor
                            </div>

                            <p class="text-content mb-2">{{ $review->content }}</p>

                            <div class="d-flex align-items-center gap-3">
                                @auth
                                    <button class="btn btn-sm p-0 border-0 d-flex align-items-center gap-1 bg-transparent" 
                                            onclick="toggleLike({{ $review->id }})" id="like-btn-{{ $review->id }}">
                                        
                                        <i class="bi {{ $review->likes->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-muted' }}" 
                                           id="like-icon-{{ $review->id }}"></i>
                                        
                                        <span class="text-grey small fw-bold" id="like-count-{{ $review->id }}">
                                            {{ $review->likes->count() }} {{ $review->likes->count() == 1 ? 'Like' : 'Likes' }}
                                        </span>
                                    </button>
                                @else
                                    <span class="text-grey small fw-bold">
                                        <i class="bi bi-heart"></i> {{ $review->likes->count() }} {{ $review->likes->count() == 1 ? 'Like' : 'Likes' }}
                                    </span>
                                @endauth

                                @if(Auth::check() && Auth::user()->role == 'admin')
                                    <button class="btn btn-link p-0 text-danger small text-decoration-none" 
                                            onclick="confirmDeleteReview({{ $review->id }}, 'other')" 
                                            style="font-size: 0.8rem;">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    @if(!auth()->check() || !$userReview)
                        <div class="text-center py-5 border rounded border-secondary border-opacity-25 bg-dark bg-opacity-25 mt-4">
                            <i class="bi bi-chat-square-text fs-2 text-secondary mb-3 d-block"></i>
                            <p class="text-white-50">Belum ada review untuk film ini.</p>
                        </div>
                    @endif
                @endforelse
            </div>

        </div>
    </div>
</div>

@include('components.modals') 

<script>
    function toggleEditMode() {
        var display = document.getElementById('my-review-display');
        var form = document.getElementById('my-review-form');
        if (display.style.display === 'none') {
            display.style.display = 'block'; form.style.display = 'none';
        } else {
            display.style.display = 'none'; form.style.display = 'block';
        }
    }

    // FUNGSI KONFIRMASI DELETE DENGAN SWEETALERT
    function confirmDeleteReview(reviewId, type) {
        Swal.fire({
            title: 'Hapus Review?',
            text: "Review ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#1e2329', // Dark mode background
            color: '#fff' // Dark mode text
        }).then((result) => {
            if (result.isConfirmed) {
                executeDeleteReview(reviewId, type);
            }
        });
    }

    // EKSEKUSI DELETE KE SERVER
    function executeDeleteReview(reviewId, type) {
        fetch(`/reviews/${reviewId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Sukses! Tampilkan notifikasi kecil
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 2000,
                    background: '#1e2329', color: '#fff', iconColor: '#41b883'
                });
                Toast.fire({ icon: 'success', title: 'Review dihapus' });

                // Hapus elemen dari layar
                if (type === 'self') {
                    // Kalau review sendiri, reload biar form muncul lagi
                    setTimeout(() => location.reload(), 1000);
                } else {
                    // Kalau admin hapus review orang, hilangkan barisnya aja
                    let item = document.getElementById(`review-item-${reviewId}`);
                    if(item) item.remove();
                }
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
        });
    }

    function toggleLike(reviewId) {
        let icon = document.getElementById(`like-icon-${reviewId}`);
        let count = document.getElementById(`like-count-${reviewId}`);

        fetch(`/reviews/${reviewId}/like`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            // FIX LOGIC SINGULAR/PLURAL
            let label = (data.count === 1) ? 'Like' : 'Likes';
            count.innerText = `${data.count} ${label}`;
            
            if (data.liked) {
                icon.className = 'bi bi-heart-fill text-danger';
                icon.style.transform = "scale(1.2)";
                setTimeout(() => icon.style.transform = "scale(1)", 200);
            } else {
                icon.className = 'bi bi-heart text-muted';
            }
        });
    }
</script>

@endsection