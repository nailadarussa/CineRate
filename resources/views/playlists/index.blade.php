@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-collection-play me-2"></i>Koleksi Playlist</h2>
            <p class="text-muted mb-0">Daftar film favoritmu yang sudah disusun rapi.</p>
        </div>
        <button class="btn btn-dark fw-bold px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#createPlaylistModal">
            <i class="bi bi-plus-lg me-2"></i> Buat Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
        @forelse($playlists as $list)
        <div class="col">
            <a href="{{ route('playlists.show', $list->id) }}" class="text-decoration-none text-dark playlist-card d-block">
                
                <div class="playlist-cover mb-3">
                    @if($list->films->count() > 0)
                        @foreach($list->films->take(3) as $index => $film)
                            @php
                                $imgSrc = Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster);
                                $stackClass = 'stack-' . ($index + 1); // stack-1, stack-2, stack-3
                            @endphp
                            <div class="poster-stack {{ $stackClass }}" style="background-image: url('{{ $imgSrc }}');"></div>
                        @endforeach
                    @else
                        <div class="poster-stack stack-1 bg-light d-flex align-items-center justify-content-center border">
                            <i class="bi bi-film fs-1 text-muted opacity-25"></i>
                        </div>
                    @endif
                </div>

                <h5 class="fw-bold mb-1 text-truncate">{{ $list->name }}</h5>
                <p class="text-muted small mb-0">{{ $list->films->count() }} Film</p>
                @if($list->description)
                    <p class="text-muted small text-truncate opacity-75">{{ $list->description }}</p>
                @endif
            </a>
        </div>
        @empty
        <div class="col-12 py-5 text-center">
            <div class="bg-white p-5 rounded-4 border border-dashed">
                <i class="bi bi-folder-x fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada playlist.</h5>
            </div>
        </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="createPlaylistModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Buat Playlist Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('playlists.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">NAMA PLAYLIST</label>
                        <input type="text" name="name" class="form-control bg-light border-0" placeholder="Misal: Action Terbaik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">DESKRIPSI</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4 fw-bold">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection