@extends('layouts.app')

@section('content')

<style>
    /* ... (Style body, wrapper, card, input sama seperti sebelumnya) ... */
    
    body { background-color: #f0f2f5; }
    .login-wrapper {
        min-height: 80vh;
        display: flex; align-items: center; justify-content: center; padding: 20px;
    }
    .login-card-modern {
        background: #fff; width: 100%; max-width: 450px; padding: 3rem 2.5rem;
        border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        text-align: center; position: relative; overflow: hidden;
    }

    /* INPUT STYLE */
    .input-group-animate { position: relative; margin-bottom: 25px; text-align: left; }
    .input-field {
        width: 100%; padding: 15px 20px 15px 50px; height: 55px;
        border: 2px solid #eee; border-radius: 16px; background: #fcfcfc;
        outline: none; font-size: 15px; font-weight: 500; transition: all 0.3s ease; color: #333;
    }
    .input-field:focus, .input-field:valid {
        border-color: var(--cr-primary); background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .input-label {
        position: absolute; top: 18px; left: 50px; color: #aaa; font-size: 15px;
        pointer-events: none; transition: 0.3s ease; background: transparent;
    }
    .input-field:focus ~ .input-label, .input-field:valid ~ .input-label {
        top: -10px; left: 20px; font-size: 12px; color: var(--cr-primary);
        background: #fff; padding: 0 8px; font-weight: 700; border-radius: 10px;
    }
    .input-icon {
        position: absolute; top: 50%; transform: translateY(-50%); left: 20px;
        font-size: 1.2rem; color: #ccc; transition: 0.3s;
    }
    .input-field:focus ~ .input-icon { color: var(--cr-primary); }

    /* TOMBOL LOGIN */
    .btn-login-modern {
        width: 100%; height: 55px; background: var(--cr-primary); color: white;
        border: none; border-radius: 16px; font-size: 16px; font-weight: 700;
        letter-spacing: 1px; cursor: pointer; transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .btn-login-modern:hover {
        background: #000; transform: translateY(-3px); box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    }

    /* --- PERBAIKAN LINK LUPA PASSWORD (biar ga panjang kotaknya) --- */
    .forgot-container {
        display: flex;           /* Pakai Flexbox */
        justify-content: flex-end; /* Rata Kanan */
        margin-bottom: 25px;     /* Jarak ke tombol login */
    }
    .forgot-link {
        font-size: 13px;
        color: #888;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;   /* PENTING: Lebar sesuai teks aja */
        transition: color 0.2s;
    }
    .forgot-link:hover { 
        color: var(--cr-primary); 
        text-decoration: underline;
    }

    /* Logo & Footer */
    .brand-logo {
        font-size: 2rem; font-weight: 900; color: var(--cr-primary);
        margin-bottom: 5px; display: block; letter-spacing: -1px;
    }
    .register-text { margin-top: 30px; font-size: 14px; color: #666; }
    .register-text a { color: var(--cr-accent-green); font-weight: 700; text-decoration: none; }
    .register-text a:hover { text-decoration: underline; }
</style>

<div class="login-wrapper">
    <div class="login-card-modern">
        
        <div class="mb-5">
            <span class="brand-logo">CineRate</span>
            <h4 class="fw-bold text-dark">Welcome Back!</h4>
            <p class="text-muted small">Masukkan kredensial Anda untuk akses fitur penuh.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center mb-4 p-3 text-start">
                <i class="bi bi-exclamation-circle-fill me-3 fs-4"></i>
                <div class="small lh-sm">
                    <strong>Login Gagal!</strong><br>
                    Email atau password salah.
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group-animate">
                <input type="email" name="email" class="input-field @error('email') is-invalid-border @enderror" value="{{ old('email') }}" required>
                <label class="input-label">Email Address</label>
                <i class="bi bi-envelope input-icon"></i>
            </div>

            <div class="input-group-animate">
                <input type="password" name="password" class="input-field" required>
                <label class="input-label">Password</label>
                <i class="bi bi-lock input-icon"></i>
            </div>

            @if (Route::has('password.request'))
                <div class="forgot-container">
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                </div>
            @endif

            <button type="submit" class="btn-login-modern">
                SIGN IN
            </button>

            <div class="register-text">
                Belum punya akun? <a href="{{ route('register') }}">Buat Akun Sekarang</a>
            </div>

        </form>
    </div>
</div>

@endsection