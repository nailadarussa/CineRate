@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f0f2f5; }
    
    .auth-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .auth-card {
        background: #fff;
        width: 100%;
        max-width: 550px;
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        text-align: center;
    }

    /* LABEL DI ATAS INPUT */
    .form-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        display: block;
        text-align: left;
    }
    
    /* INPUT MODERN */
    .input-modern {
        width: 100%;
        padding: 12px 20px 12px 50px; /* Padding Kiri Besar (50px) Biar Ikon Gak Nabrak Teks */
        height: 50px;
        border: 2px solid #eef2f6;
        border-radius: 12px;
        background: #fcfcfc;
        outline: none;
        font-size: 15px;
        color: #333;
        transition: all 0.3s;
    }
    .input-modern:focus {
        border-color: var(--cr-primary);
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* POSISI IKON YANG BENAR (Vertikal Center di dalam Input) */
    .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%); /* Tarik ke atas 50% biar pas di tengah */
        left: 20px;
        font-size: 1.2rem;
        color: #adb5bd;
        transition: 0.3s;
        pointer-events: none; /* Biar bisa klik tembus ke input */
    }
    
    /* Warna Ikon saat Fokus */
    .input-modern:focus + .input-icon {
        color: var(--cr-primary);
    }

    /* TOMBOL */
    .btn-auth {
        width: 100%;
        height: 55px;
        background: var(--cr-primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: 0.3s;
        margin-top: 10px;
    }
    .btn-auth:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="mb-5">
            <h3 class="fw-bold text-dark mb-2">Buat Akun Baru</h3>
            <p class="text-muted small">Bergabunglah dengan komunitas pecinta film Indonesia.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            <div class="mb-4 text-start">
                <label class="form-label">Nama Lengkap</label>
                <div class="position-relative">
                    <input type="text" name="name" class="input-modern @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: pemweb1" required autofocus>
                    <i class="bi bi-person input-icon"></i>
                </div>
                @error('name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 text-start">
                <label class="form-label">Alamat Email</label>
                <div class="position-relative">
                    <input type="email" name="email" class="input-modern @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 text-start">
                <label class="form-label">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" class="input-modern @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                    <i class="bi bi-lock input-icon"></i>
                </div>
                @error('password') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-5 text-start">
                <label class="form-label">Konfirmasi Password</label>
                <div class="position-relative">
                    <input type="password" name="password_confirmation" class="input-modern" placeholder="Ulangi password..." required>
                    <i class="bi bi-check2-circle input-icon"></i>
                </div>
            </div>

            <button type="submit" class="btn-auth">
                DAFTAR SEKARANG
            </button>

            <div class="mt-4 text-muted small">
                Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #666;">Login di sini</a>
            </div>

        </form>
    </div>
</div>
@endsection