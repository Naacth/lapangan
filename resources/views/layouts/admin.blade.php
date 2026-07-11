<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — SportBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        @keyframes sidebarGlow { 0%,100%{box-shadow:4px 0 30px rgba(37,99,235,0.1)} 50%{box-shadow:4px 0 40px rgba(124,58,237,0.2)} }
        @keyframes fadeSlide { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }
        @keyframes topbarIn { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.15)} }
        :root { --sidebar-w: 270px; --primary: #2563EB; --accent: #F59E0B; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #F1F5F9; margin: 0; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: linear-gradient(180deg, #0a0e1a 0%, #0F172A 50%, #0d1b3e 100%);
            color: #fff; overflow-y: auto;
            display: flex; flex-direction: column;
            z-index: 1000; transition: transform .3s;
            animation: sidebarGlow 4s ease-in-out infinite;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: #fff;
        }
        .sidebar-brand .logo-text { font-size: 1.5rem; font-weight: 900; letter-spacing: -0.5px; }
        .sidebar-brand .logo-text span { color: #F59E0B; }
        .sidebar-brand small { display: block; font-size: 0.62rem; font-weight: 500; color: rgba(255,255,255,0.3); margin-top: 2px; letter-spacing: 2px; text-transform: uppercase; }
        .sidebar-brand .admin-badge { background: linear-gradient(135deg,#2563EB,#7C3AED); color: #fff; border-radius: 6px; padding: 2px 8px; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px; }
        .sidebar-nav { padding: 0.75rem 0; flex: 1; }
        .sidebar-nav .nav-label {
            font-size: 0.6rem; letter-spacing: 2px; text-transform: uppercase;
            color: rgba(255,255,255,0.25); padding: 1rem 1.25rem 0.3rem; font-weight: 700;
        }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 0.65rem 1.25rem;
            color: rgba(255,255,255,0.55); text-decoration: none;
            font-size: 0.875rem; font-weight: 500;
            transition: all .25s; position: relative;
            margin: 2px 10px; border-radius: 10px;
        }
        .sidebar-nav a::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 0; background: linear-gradient(to bottom, #2563EB, #7C3AED);
            border-radius: 0 2px 2px 0; transition: height .25s;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar-nav a:hover::before { height: 60%; }
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(124,58,237,0.15));
            color: #fff; border: 1px solid rgba(37,99,235,0.25);
        }
        .sidebar-nav a.active::before { height: 65%; }
        .sidebar-nav a i { font-size: 1rem; width: 20px; }
        .nav-badge { margin-left: auto; background: #EF4444; color: #fff; border-radius: 10px; padding: 1px 7px; font-size: 0.68rem; font-weight: 700; animation: pulse 2s ease-in-out infinite; }
        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,0.06); font-size: 0.8rem; }
        .user-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg,#2563EB,#7C3AED); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; color: #fff; flex-shrink: 0; }
        .sidebar-footer .user-name { color: #fff; font-weight: 700; font-size: 0.875rem; }
        .sidebar-footer .user-role { color: rgba(255,255,255,0.35); font-size: 0.72rem; text-transform: capitalize; }

        /* Main content */
        .main-wrapper { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid #E2E8F0;
            padding: 0.85rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 100;
            animation: topbarIn 0.4s ease both;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .topbar .page-title { margin: 0; font-weight: 800; color: #0F172A; font-size: 1.05rem; letter-spacing: -0.3px; }
        .topbar .breadcrumb { font-size: 0.78rem; margin: 0; }
        .page-content { padding: 1.5rem; flex: 1; animation: fadeSlide 0.4s ease both; }

        /* Cards & Badges */
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .stat-card { background: #fff; border-radius: 12px; padding: 1.5rem; position: relative; overflow: hidden; }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 800; color: #0F172A; }
        .stat-card .stat-label { font-size: 0.8rem; color: #64748B; font-weight: 500; }
        .badge-pending { background: #FEF3C7; color: #92400E; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-confirmed { background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-rejected, .badge-cancelled { background: #FEE2E2; color: #991B1B; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-completed { background: #EDE9FE; color: #4C1D95; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
@php $pendingCount = \App\Models\Booking::where('status','pending')->count(); @endphp
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo-text">⚽ Sport<span>Book</span></div>
            <span class="admin-badge">ADMIN</span>
        </div>
        <small>Panel Pengelola</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-label">Manajemen</div>
        <a href="{{ route('admin.fields.index') }}" class="{{ request()->routeIs('admin.fields.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> Lapangan
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Booking
            @if($pendingCount > 0) <span class="nav-badge">{{ $pendingCount }}</span> @endif
        </a>
        <div class="nav-label">Laporan</div>
        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Laporan Pendapatan
        </a>
        <div class="nav-label">Lainnya</div>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
    </nav>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name ?? '' }}</div>
                <div class="user-role">{{ auth()->user()->role ?? '' }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-sm w-100 fw-600" style="background:rgba(239,68,68,0.1);color:#FCA5A5;border:1px solid rgba(239,68,68,0.2);border-radius:8px;"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
        </form>
    </div>
</div>

<div class="main-wrapper">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')" style="border-radius:8px;">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 py-1 px-3 mb-0" style="border-radius:10px;font-size:0.82rem;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 py-1 px-3 mb-0" style="border-radius:10px;font-size:0.82rem;">
                    <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
                </div>
            @endif
            <div class="user-avatar" style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#2563EB,#7C3AED);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;color:#fff;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        </div>
    </div>

    <div class="page-content">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
