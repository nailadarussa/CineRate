@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f0f2f5; }
    
    .auth-wrapper {
        min-height: 80vh;
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

    /* HEADER */
    .auth-header { margin-bottom: 2rem; }
    .auth-header h3 { font-weight: 800; color: #1a1b1b; margin-bottom: 0.5rem; }
    .auth-header p { color: #6c757d; font-size: 0.9rem; }

    /* INPUT STYLE MODERN */
    .input-group-modern {
        position: relative;
        margin-bottom: 20px;
        text-align: left;
    }
    
    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    .input-modern {
        width: 100%;
        padding: 12px 20px 12px 50px; /* Padding kiri untuk ikon */
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
        border-color: #1a1b1b; /* Warna Primary */
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* IKON DI DALAM INPUT */
    .input-icon {
        position: absolute;
        top: 42px; /* Sesuaikan dengan tinggi label + padding input */
        left: 20px;
        font-size: 1.2rem;
        color: #adb5bd;
        transition: 0.3s;
        pointer-events: none;
    }
    .input-modern:focus ~ .input-icon { color: #1a1b1b; }

    /* TOMBOL */
    .btn-auth {
        width: 100%;
        height: 50px;
        background: #1a1b1b;
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
    
    .btn-cancel {
        display: block;
        margin-top: 20px;
        color: #6c757d;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.9rem;
    }
    .btn-cancel:hover { color: #1a1b1b; text-decoration: underline; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h3>Ubah Password</h3>
            <p>Amankan akunmu dengan password yang kuat.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center small">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.change.update') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="input-group-modern">
                <label class="form-label">Password Lama</label>
                <input type="password" name="current_password" class="input-modern @error('current_password') is-invalid @enderror" placeholder="Masukkan password saat ini..." required>
                <i class="bi bi-key input-icon"></i>
                @error('current_password')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group-modern">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="input-modern @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                <i class="bi bi-lock input-icon"></i>
                @error('password')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group-modern">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="input-modern" placeholder="Ulangi password baru..." required>
                <i class="bi bi-shield-lock input-icon"></i>
            </div>

            <button type="submit" class="btn-auth">
                SIMPAN PERUBAHAN
            </button>

            <a href="{{ route('welcome') }}" class="btn-cancel">Batal, kembali ke Home</a>

        </form>
    </div>
</div>
@endsection