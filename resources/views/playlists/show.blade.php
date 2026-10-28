@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">
    
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-4 d-flex justify-content-between align-items-center">
        <div>
            <div class="d-flex align-items-center gap-3 mb-1">
                <i class="bi bi-folder2-open fs-3"></i>
                <h2 class="fw-bold mb-0 text-dark">{{ $playlist->name }}</h2>
                
                <button class="btn btn-outline-secondary p-1 d-flex align-items-center justify-content-center"
                        data-bs-toggle="modal" data-bs-target="#editPlaylistModal"
                        style="width:32px; height:32px; border-radius:10px;">
                    <i class="bi bi-pencil"></i>
                </button>

            </div>
            <p class="text-muted mb-0">
                {{ $playlist->description ?? 'Koleksi pribadi.' }} 
                <span class="mx-2">•</span> 
                <span class="fw-bold text-dark" id="film-count-display">{{ $playlist->films()->count() }} Film</span>
            </p>
        </div>
        <a href="{{ route('playlists.index') }}" class="btn btn-light border fw-bold text-muted rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
        @forelse($playlist->films as $film)
        <div class="col position-relative group-action" id="card-film-{{ $film->id }}">
            <div class="movie-card shadow-sm h-100">
                <a href="{{ route('films.show', $film->slug) }}" class="text-decoration-none text-dark d-block h-100">
                    <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                         alt="{{ $film->title }}">
                    <div class="p-3">
                        <h6 class="fw-bold text-truncate mb-1" style="font-size: 0.9rem;">{{ $film->title }}</h6>
                        <small class="text-muted">{{ $film->release_year }}</small>
                    </div>
                </a>
            </div>

            <button class="btn btn-dark bg-black bg-opacity-50 border-0 rounded-circle text-white d-flex align-items-center justify-content-center btn-trash position-absolute top-0 end-0 m-2" 
                    style="width: 32px; height: 32px; backdrop-filter: blur(4px); z-index: 10;" 
                    onclick="confirmRemove({{ $playlist->id }}, {{ $film->id }})">
                <i class="bi bi-trash3-fill" style="font-size: 0.85rem;"></i>
            </button>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="py-5 bg-white rounded-4 border border-dashed">
                <i class="bi bi-film fs-1 text-muted opacity-25 mb-3 d-block"></i>
                <h4 class="text-muted fw-bold">Watchlist ini masih kosong.</h4>
                <p class="text-muted small">Cari film favoritmu dan tambahkan ke sini.</p>
                <a href="{{ route('films.index') }}" class="btn btn-dark rounded-pill px-4 mt-2 fw-bold">Jelajahi Film</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        @if(method_exists($films, 'links'))
            {{ $films->links() }}
        @endif
    </div>

</div>

<div class="modal fade" id="editPlaylistModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Watchlist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('playlists.update', $playlist->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">NAMA WATCHLIST</label>
                        <input type="text" name="name" class="form-control bg-light border-0" 
                               value="{{ $playlist->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">DESKRIPSI</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="3">{{ $playlist->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark fw-bold px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-trash { opacity: 0; transition: all 0.2s ease-in-out; cursor: pointer; }
    .group-action:hover .btn-trash { opacity: 1; }
    .btn-trash:hover { background-color: #dc3545 !important; opacity: 1 !important; transform: scale(1.1); }
</style>

<script>
    // 1. FIX BACK BUTTON CACHE (Agar saat back, data terupdate)
    window.addEventListener( "pageshow", function ( event ) {
      var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
      if ( historyTraversal ) { window.location.reload(); }
    });

    // 2. SWEETALERT DELETE
    function confirmRemove(playlistId, filmId) {
        Swal.fire({
            title: 'Hapus dari Watchlist?',
            text: "Film ini akan dihapus dari daftar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1a1b1b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                executeRemove(playlistId, filmId);
            }
        });
    }

    // 3. AJAX EXECUTE
    function executeRemove(playlistId, filmId) {
        let card = document.getElementById(`card-film-${filmId}`);
        
        // Perhatikan URL: /watchlists/
        fetch(`/watchlists/${playlistId}/remove/${filmId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Animasi Fade Out
                card.style.transition = 'all 0.3s ease';
                card.style.transform = 'scale(0.8)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    card.remove(); 
                    
                    // Update Angka
                    let countDisplay = document.getElementById('film-count-display');
                    let currentCount = parseInt(countDisplay.innerText);
                    let newCount = currentCount - 1;
                    countDisplay.innerText = newCount + ' Film';

                    // Jika kosong reload
                    if(newCount === 0) {
                        location.reload(); 
                    } else {
                        // Toast Sukses
                        const Toast = Swal.mixin({
                            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                            timerProgressBar: true,
                        });
                        Toast.fire({ icon: 'success', title: 'Film berhasil dihapus' });
                    }
                }, 300); 
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Oops!', 'Terjadi kesalahan koneksi.', 'error');
        });
    }
</script>
@endsection