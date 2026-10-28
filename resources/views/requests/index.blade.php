@extends('layouts.app')

@section('content')

<style>
    /* Card Style (Sama dengan Auth) */
    .request-card {
        background: #fff;
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    /* HEADER */
    .request-header h2 { 
        font-weight: 900; 
        color: #1a1b1b; 
        font-size: 2rem; /* Font lebih besar & tegas */
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }
    .request-header p { color: #6c757d; }

    /* INPUT STYLE (Sama dengan Register) */
    .input-group-modern {
        position: relative;
        margin-bottom: 20px;
        text-align: left;
    }
    
    .form-label {
        font-size: 0.9rem; /* Font label sedikit diperbesar */
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    .input-modern {
        width: 100%;
        padding: 12px 20px 12px 50px; /* Padding kiri untuk ikon */
        height: 55px; /* Tinggi input diperbesar biar gagah */
        border: 2px solid #eef2f6;
        border-radius: 12px;
        background: #fcfcfc;
        outline: none;
        font-size: 16px; /* Font input diperbesar */
        color: #333;
        transition: all 0.3s;
    }
    .input-modern:focus {
        border-color: #1a1b1b;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* IKON DI DALAM INPUT */
    .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%); /* Center vertikal */
        left: 20px;
        font-size: 1.2rem; /* Ukuran ikon pas (tidak kegedean) */
        color: #adb5bd;
        transition: 0.3s;
        pointer-events: none;
    }
    .input-modern:focus ~ .input-icon { color: #1a1b1b; }

    /* TOMBOL */
    .btn-request {
        width: 100%;
        height: 55px;
        background: #1a1b1b;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: 0.3s;
        margin-top: 10px;
    }
    .btn-request:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    /* RIWAYAT LIST STYLE */
    .history-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem 0;
    }
    .history-item:last-child { border-bottom: none; }
    .badge-status { font-size: 0.75rem; padding: 6px 12px; border-radius: 30px; }
</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        
        <div class="col-lg-7 mb-4">
            
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center shadow-sm p-3">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="request-card">
                <div class="request-header text-center mb-5">
                    <h2>Request Film Baru</h2>
                    <p>Bantu kami melengkapi koleksi film Indonesia.</p>
                </div>

                <form action="{{ route('requests.store') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <div class="input-group-modern">
                        <label class="form-label">JUDUL FILM <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" name="title" class="input-modern" placeholder="Masukkan judul lengkap..." required>
                            <i class="bi bi-film input-icon"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label">TAHUN RILIS</label>
                                <div class="position-relative">
                                    <input type="number" name="year" class="input-modern" placeholder="Contoh: 2024">
                                    <i class="bi bi-calendar-event input-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label">LINK POSTER (OPSIONAL)</label>
                                <div class="position-relative">
                                    <input type="url" name="poster_url" class="input-modern" placeholder="https://...">
                                    <i class="bi bi-image input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group-modern">
                        <label class="form-label">CATATAN TAMBAHAN</label>
                        <div class="position-relative">
                            <textarea name="note" class="input-modern" style="height: 120px; padding-top: 15px;" placeholder="Sutradara, Genre, atau link IMDb..."></textarea>
                            <i class="bi bi-pencil-square input-icon" style="top: 25px; transform: none;"></i>
                        </div>
                    </div>

                    <div class="form-check mb-4 ps-4">
                        <input class="form-check-input" type="checkbox" id="telahTonton" style="transform: scale(1.2); margin-top: 3px;">
                        <label class="form-check-label text-muted ms-2" for="telahTonton">
                            Saya sudah menonton film ini
                        </label>
                    </div>

                    <button type="submit" class="btn-request">
                        KIRIM REQUEST
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="request-card h-100">
                <h4 class="fw-bold mb-4 border-bottom pb-3">Riwayat Request</h4>
                
                <div class="history-list">
                    @forelse($myRequests as $req)
                        <div class="history-item d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">{{ $req->title }}</h6>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar2 me-1"></i> {{ $req->year ?? '-' }}
                                    <span class="mx-2">•</span>
                                    {{ $req->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div>
                                @if($req->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning badge-status border border-warning">Pending</span>
                                @elseif($req->status == 'approved')
                                    <span class="badge bg-success bg-opacity-10 text-success badge-status border border-success">Approved</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger badge-status border border-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 opacity-25 mb-2 d-block"></i>
                            <p>Belum ada request.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection