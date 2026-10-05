<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Akun') - UNSIA Story</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo-unsia-story.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <style>
        :root {
            --dark-blue: #0d1b2a;
            --gold: #f0c040;
        }

        body {
            font-family: 'Lexend', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f6f8;
            color: #2b3445;
        }

        .akun-navbar {
            background-color: var(--dark-blue);
            padding: 0.85rem 0;
        }

        .akun-navbar .brand {
            color: var(--gold);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .akun-navbar a.nav-aksi {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .akun-navbar a.nav-aksi:hover,
        .akun-navbar a.nav-aksi.aktif {
            color: var(--gold);
        }

        .akun-navbar a.nav-aksi.aktif {
            font-weight: 600;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(13, 27, 42, 0.06), 0 1px 12px rgba(13, 27, 42, 0.04);
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--dark-blue);
            border: none;
            font-weight: 600;
        }

        .btn-gold:hover,
        .btn-gold:focus {
            background-color: #e0b030;
            color: var(--dark-blue);
        }

        .alert {
            border: 0;
            border-radius: 10px;
        }
    </style>

    @yield('styles')
</head>
<body>

<nav class="akun-navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('profil.edit') }}" class="brand">
            <img src="{{ asset('assets/images/logo-unsia-story.png') }}" alt="" height="28"
                 onerror="this.style.display='none'">
            <span>UNSIA Story</span>
        </a>

        <div class="d-flex align-items-center gap-3">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-aksi">
                        <i class="fas fa-gauge me-1"></i>Panel Admin
                    </a>
                @else
                    <a href="{{ route('profil.edit') }}"
                       class="nav-aksi {{ request()->routeIs('profil.*') ? 'aktif' : '' }}">
                        <i class="fas fa-user me-1"></i>Profil
                    </a>
                    <a href="{{ route('cashback.index') }}"
                       class="nav-aksi {{ request()->routeIs('cashback.*') ? 'aktif' : '' }}">
                        <i class="fas fa-money-bill-transfer me-1"></i>Cashback
                    </a>
                @endif

                <a href="{{ route('home') }}" class="nav-aksi" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                </a>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
@yield('scripts')

</body>
</html>
