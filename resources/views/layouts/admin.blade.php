<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CineRate Console</title>
    
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* --- ADMIN DASHBOARD STYLE --- */
        body {
            background-color: #f3f4f6; /* Abu-abu muda modern */
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* 1. SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background: #1e293b; /* Warna Slate Gelap (Mirip referensi) */
            color: #94a3b8;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 100;
            padding-top: 0;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding-left: 25px;
            background: #0f172a; /* Lebih gelap dikit untuk logo */
            color: #fff;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-link {
            color: #cbd5e1;
            padding: 15px 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .nav-link.active {
            background: #334155;
            color: #41b883; /* Hijau CineRate */
            border-left-color: #41b883;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .nav-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin: 25px 25px 10px;
            font-weight: 700;
        }

        /* 2. MAIN CONTENT AREA */
        .main-content {
            margin-left: 250px; /* Geser konten ke kanan */
            padding: 0;
        }

        /* 3. TOP HEADER */
        .top-header {
            height: 70px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .avatar-circle {
            width: 35px;
            height: 35px;
            background-color: #41b883;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* 4. CONTENT WRAPPER */
        .content-wrapper {
            padding: 30px;
        }

        /* Card Style Override */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: #fff;
            margin-bottom: 20px;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px;
            font-weight: 700;
            color: #334155;
        }
        
        /* Table Style */
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px;
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
            color: #334155;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-camera-reels-fill me-2 text-success"></i> CR ADMIN
        </div>
        
        <div class="nav flex-column py-3">
            <div class="nav-title">Main Menu</div>
            
            <a href="{{ route('admin.requests') }}" class="nav-link {{ Request::is('admin/requests*') ? 'active' : '' }}">
                <i class="bi bi-inbox-fill"></i> Permintaan Masuk
            </a>

            <div class="nav-title">Database Film</div>
            
            <a href="{{ route('admin.films.index') }}" class="nav-link {{ Request::is('admin/films') ? 'active' : '' }}">
                <i class="bi bi-database-fill"></i> Semua Film
            </a>
            
            <a href="{{ route('admin.films.create') }}" class="nav-link {{ Request::is('admin/films/create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i> Tambah Film
            </a>

            <div class="nav-title">System</div>

            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Manajemen User
            </a>
            <a href="{{ route('home') }}" target="_blank" class="nav-link">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Website
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start text-danger mt-3">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <header class="top-header">
            <h5 class="m-0 fw-bold text-secondary">Dashboard Overview</h5>
            
            <div class="user-profile">
                <div class="text-end me-2 d-none d-md-block">
                    <small class="d-block text-muted" style="font-size: 10px;">LOGGED IN AS</small>
                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                </div>
                <div class="avatar-circle">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

</body>
</html>