@auth

<style>
    /* Styling Checkbox Playlist */
    .playlist-option { transition: all 0.2s; cursor: pointer; }
    .playlist-checkbox:checked + .playlist-option {
        background-color: #f0fdf4; /* Hijau muda pudar */
        border-color: #41b883;
    }
    .playlist-checkbox:checked + .playlist-option .icon-indicator {
        color: #41b883 !important; /* Ikon jadi hijau */
        transform: scale(1.1);
    }
</style>

<div class="modal fade" id="addToPlaylistModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-white pb-2">
                <h6 class="modal-title fw-bold text-dark">KELOLA WATCHLIST</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-3 bg-light" style="max-height: 400px; overflow-y: auto;">
                @php 
                    $playlists = App\Models\Playlist::where('user_id', Auth::id())->with('films')->get(); 
                @endphp
                
                @if($playlists->count() > 0)
                    <div class="d-flex flex-column gap-2">
                        @foreach($playlists as $list)
                            @php $exists = $list->films->contains($film->id); @endphp

                            <label class="w-100 cursor-pointer position-relative">
                                <input type="checkbox" 
                                       class="playlist-checkbox position-absolute opacity-0" 
                                       onchange="togglePlaylist({{ $list->id }}, {{ $film->id }}, this)"
                                       {{ $exists ? 'checked' : '' }}>
                                
                                <div class="playlist-option d-flex justify-content-between align-items-center p-3 shadow-sm border border-1 rounded-3 bg-white">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi {{ $exists ? 'bi-check-circle-fill' : 'bi-circle' }} fs-5 icon-indicator text-muted transition-all"></i>
                                        <div>
                                            <span class="fw-bold d-block text-dark" style="font-size: 0.9rem;">{{ $list->name }}</span>
                                            <small class="text-muted status-text">{{ $exists ? 'Tersimpan' : $list->films->count().' Film' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-3 pt-2 border-top">
                        <a href="{{ route('playlists.index') }}" class="text-decoration-none small fw-bold text-muted">
                            <i class="bi bi-plus-lg"></i> Buat Watchlist Baru
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted small mb-3">Belum ada watchlist.</p>
                        <a href="{{ route('playlists.index') }}" class="btn btn-outline-dark btn-sm fw-bold rounded-pill px-4">Buat Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function togglePlaylist(playlistId, filmId, checkbox) {
        let card = checkbox.nextElementSibling;
        let icon = card.querySelector('.icon-indicator');
        let text = card.querySelector('.status-text');

        let originalIconClass = icon.className;
        icon.className = 'spinner-border spinner-border-sm text-secondary';

        let formData = new FormData();
        formData.append('playlist_id', playlistId);

        // Pastikan route ini benar (/watchlists/toggle)
        fetch(`/watchlists/toggle/${filmId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'added') {
                icon.className = 'bi bi-check-circle-fill text-success fs-5 icon-indicator';
                checkbox.checked = true;
                text.innerText = 'Tersimpan';
            } else {
                icon.className = 'bi bi-circle text-muted fs-5 icon-indicator';
                checkbox.checked = false;
                text.innerText = 'Dihapus';
            }
        })
        .catch(err => {
            console.error(err);
            alert("Gagal koneksi.");
            icon.className = originalIconClass;
            checkbox.checked = !checkbox.checked;
        });
    }
</script>

@endauth