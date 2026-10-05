<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Admin') - UNSIA Story Admin</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo-unsia-story.png') }}" type="image/png">

    {{-- Bootstrap 5.3 CSS (lokal, sama seperti layout publik) --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    {{-- Google Fonts: Lexend --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 (lokal) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <style>
        :root {
            --dark-blue: #0d1b2a;
            --gold: #f0c040;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Lexend', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f6f8;
            color: #2b3445;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--dark-blue);
            color: #fff;
            padding-top: 0;
            overflow-y: auto;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        .admin-sidebar .sidebar-brand {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-sidebar .sidebar-brand span {
            color: var(--gold);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: var(--gold);
            background-color: rgba(240, 192, 64, 0.1);
            border-left-color: var(--gold);
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .admin-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: 100vh;
        }

        .admin-topbar {
            background: #fff;
            padding: 0.85rem 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
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

        .btn-gold:focus-visible {
            outline: 2px solid var(--dark-blue);
            outline-offset: 2px;
        }

        /* Nama di topbar adalah tautan ke profil, beri sinyal visual. */
        .topbar-profil {
            color: #6c7a90;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .topbar-profil:hover {
            background-color: #f1f3f5;
            color: var(--dark-blue);
        }

        /* Kartu & tabel */
        .admin-content .card {
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(13, 27, 42, 0.06), 0 1px 12px rgba(13, 27, 42, 0.04);
        }

        .admin-content .table > :not(caption) > * > * {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .admin-content .table > thead th {
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6c7a90;
            border-bottom-color: #e9ecef;
        }

        .admin-content .table > tbody > tr:last-child > td {
            border-bottom: 0;
        }

        .admin-content .badge {
            font-weight: 600;
            padding: 0.4em 0.7em;
        }

        .admin-content .alert {
            border: 0;
            border-radius: 10px;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1030;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('assets/images/logo-unsia-story.png') }}" alt="Logo" height="30" onerror="this.style.display='none'">
            <span>UNSIA Story</span>
        </div>
        <nav class="mt-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}"
                       href="{{ route('admin.blog.index') }}">
                        <i class="fas fa-newspaper"></i> Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.callback.*') ? 'active' : '' }}"
                       href="{{ route('admin.callback.index') }}">
                        <i class="fas fa-phone-alt"></i> Callback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.bantuan.*') ? 'active' : '' }}"
                       href="{{ route('admin.bantuan.index') }}">
                        <i class="fas fa-hand-holding-dollar"></i> Bantuan Pendanaan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                       href="{{ route('admin.events.index') }}">
                        <i class="fas fa-calendar-check"></i> Events
                    </a>
                </li>
            </ul>

            <hr class="mx-3 border-secondary">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tahun-ajar.*') ? 'active' : '' }}"
                       href="{{ route('admin.tahun-ajar.index') }}">
                        <i class="fas fa-calendar-alt"></i> Tahun Ajar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.pengajuan-nim.*') ? 'active' : '' }}"
                       href="{{ route('admin.pengajuan-nim.index') }}">
                        <i class="fas fa-id-card"></i> Pengajuan NIM
                        @if (($jumlahPengajuanNim ?? 0) > 0)
                            <span class="badge rounded-pill bg-danger ms-auto">{{ $jumlahPengajuanNim }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cashback.*') ? 'active' : '' }}"
                       href="{{ route('admin.cashback.index') }}">
                        <i class="fas fa-money-bill-transfer"></i> Cashback
                        @if (($jumlahCashback ?? 0) > 0)
                            <span class="badge rounded-pill bg-danger ms-auto">{{ $jumlahCashback }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <hr class="mx-3 border-secondary">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}"
                       href="{{ route('profil.edit') }}">
                        <i class="fas fa-user-gear"></i> Profil Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Lihat Website
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <a class="nav-link" href="#"
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="admin-content">
        {{-- Top Bar --}}
        <div class="admin-topbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-2 p-0" id="sidebarToggle">
                    <i class="fas fa-bars fs-5"></i>
                </button>
                <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
            </div>
            <a href="{{ route('profil.edit') }}"
               class="d-flex align-items-center text-decoration-none topbar-profil" title="Profil saya">
                <span class="small me-2">
                    {{ auth()->user()->nama ?? auth()->user()->name ?? 'Admin' }}
                </span>
                @if (auth()->user()?->foto_url)
                    <img src="{{ auth()->user()->foto_url }}" alt="" class="rounded-circle"
                         style="width: 32px; height: 32px; object-fit: cover;">
                @else
                    <i class="fas fa-user-circle text-muted fs-4"></i>
                @endif
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Bootstrap 5.3 JS (lokal, sudah termasuk Popper) --}}
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
