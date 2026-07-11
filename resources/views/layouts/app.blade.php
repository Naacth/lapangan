<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SportBook') — Reservasi Lapangan Online</title>
    <meta name="description" content="@yield('description', 'Sistem reservasi lapangan olahraga online terpercaya. Booking futsal, badminton, basket, mini soccer dengan mudah.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --accent: #F59E0B;
            --success: #10B981;
            --danger: #EF4444;
            --dark: #0F172A;
            --card-bg: #1E293B;
            --surface: #0F172A;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #F1F5F9;
            color: #1E293B;
        }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px; }
        .navbar-brand span { color: var(--accent); }
        .navbar {
            background: rgba(15, 23, 42, 0.97) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .navbar .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 500; transition: color .2s; }
        .navbar .nav-link:hover { color: #fff !important; }
        .btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 600; }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-accent { background: var(--accent); border-color: var(--accent); color: #fff; font-weight: 600; }
        .badge-pending { background: #F59E0B; color: #fff; }
        .badge-confirmed { background: #10B981; color: #fff; }
        .badge-rejected, .badge-cancelled { background: #EF4444; color: #fff; }
        .badge-completed { background: #6366F1; color: #fff; }
        footer { background: #0F172A; color: rgba(255,255,255,0.6); padding: 2rem 0; margin-top: 4rem; }
        footer a { color: rgba(255,255,255,0.6); text-decoration: none; }
        footer a:hover { color: #fff; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        @yield('extra-css')
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">⚽ Sport<span>Book</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('bookings.history') }}"><i class="bi bi-calendar-check"></i> Booking Saya</a></li>
                    @if(in_array(auth()->user()->role, ['admin','super_admin']))
                        <li class="nav-item"><a class="btn btn-sm btn-warning ms-1" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a></li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm ms-1" href="{{ route('register') }}">Daftar Gratis</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="container text-center">
        <p class="mb-1 fw-bold text-white">⚽ SportBook</p>
        <p class="mb-0 small">© {{ date('Y') }} SportBook. Platform Reservasi Lapangan Olahraga Terpercaya.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
