<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CineRate</title>
    <link href="https://fonts.bunny.net/css?family=nunito:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app" class="d-flex flex-column flex-grow-1">
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="brand-gradient" style="font-weight: 900; letter-spacing: 1px;">CineRate</span>
                </a>
        
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('films*') ? 'active' : '' }}" href="{{ route('films.index') }}">Films</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('playlists*') ? 'active' : '' }}" href="{{ route('playlists.index') }}">Watchlist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-white-50" href="{{ route('requests.index') }}">Request</a>
                        </li>
                    </ul>
        
                    <form action="{{ route('search') }}" method="GET" class="d-flex mx-lg-4 flex-grow-1 position-relative" style="max-width: 400px;" autocomplete="off">
                        <input class="form-control rounded-pill border-0 bg-light ps-4 pe-5 py-2" type="search" name="query" placeholder="Cari film, sutradara..." style="font-size: 0.95rem;">
                        <button class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent text-muted" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
        
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-4 fw-bold rounded-pill">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> LOGIN
                                </a>
                            </li>
                        @else
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item me-3">
                                    <a class="nav-link text-warning fw-bold small text-uppercase" href="{{ route('admin.requests') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Admin Panel
                                    </a>
                                </li>
                            @endif
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="avatar-profile avatar-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    
                                    <span class="fw-bold text-white small d-none d-md-block">
                                        {{ Auth::user()->name }}
                                    </span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-3" style="min-width: 220px;">
                                    <div class="px-3 py-2 border-bottom mb-2">
                                        <small class="text-muted fw-bold" style="font-size: 0.7rem;">MENU PENGGUNA</small>
                                    </div>
                                    <a class="dropdown-item rounded-2 py-2" href="{{ route('requests.index') }}">
                                        <i class="bi bi-clock-history me-2 text-secondary"></i> History Request
                                    </a>
                                    <a class="dropdown-item rounded-2 py-2" href="{{ route('playlists.index') }}">
                                        <i class="bi bi-collection-play me-2 text-secondary"></i> Watchlist Saya
                                    </a>
                                    <a class="dropdown-item rounded-2 py-2" href="{{ route('password.change') }}">
                                        <i class="bi bi-key me-2 text-secondary"></i> Ubah Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item rounded-2 py-2 text-danger fw-bold" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>
        
        <footer class="bg-white border-top py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-0 text-muted fw-semibold small">
                    &copy; {{ date('Y') }} CINERATE INDONESIA. ALL RIGHTS RESERVED.
                </p>
            </div>
        </footer>
    </div>
    <script>
        // Paksa reload saat user menekan tombol Back
        window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted || 
                                ( typeof window.performance != "undefined" && 
                                    window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
        });
    </script>
</body>
</html>