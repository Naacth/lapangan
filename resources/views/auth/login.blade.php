<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SportBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float2 {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-30px) rotate(-8deg); }
        }
        @keyframes fadeUp {
            from { opacity:0; transform: translateY(24px); }
            to   { opacity:1; transform: translateY(0); }
        }
        @keyframes cardIn {
            from { opacity:0; transform: translateY(40px) scale(0.95); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background: #080d1a;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* LEFT SIDE — BG */
        .left-panel {
            flex: 1; position: relative; overflow: hidden;
            display: none;
        }
        @media(min-width:992px) { .left-panel { display: flex; } }
        .left-panel img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(0.4);
        }
        .left-panel-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.7), rgba(124,58,237,0.5));
            display: flex; flex-direction: column;
            justify-content: flex-end; padding: 3rem;
        }
        .left-panel-overlay h2 { color: #fff; font-size: 2.2rem; font-weight: 900; letter-spacing: -0.8px; line-height: 1.2; }
        .left-panel-overlay p { color: rgba(255,255,255,0.7); margin-top: 0.75rem; font-size: 0.95rem; }
        .feature-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 1.5rem; }
        .feature-pill { background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); color: #fff; border-radius: 20px; padding: 6px 14px; font-size: 0.78rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.2); }
        .float-emoji { position: absolute; font-size: 3rem; opacity: 0.15; pointer-events: none; }
        .float-emoji:nth-child(1) { top: 10%; left: 10%; animation: float 5s ease-in-out infinite; }
        .float-emoji:nth-child(2) { top: 60%; left: 80%; animation: float2 7s ease-in-out infinite; font-size: 4rem; }
        .float-emoji:nth-child(3) { top: 30%; left: 60%; animation: float 6s ease-in-out infinite 1s; }

        /* RIGHT SIDE — FORM */
        .right-panel {
            width: 100%; max-width: 480px;
            background: #0F172A;
            display: flex; flex-direction: column; justify-content: center;
            padding: 2.5rem;
            position: relative; overflow: hidden;
        }
        @media(min-width:992px) { .right-panel { width: 480px; flex-shrink: 0; } }
        .right-panel::before {
            content: ''; position: absolute;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.12), transparent 70%);
            top: -100px; right: -100px; pointer-events: none;
        }
        .right-panel::after {
            content: ''; position: absolute;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(124,58,237,0.08), transparent 70%);
            bottom: -80px; left: -60px; pointer-events: none;
        }

        .logo-wrap { animation: fadeUp 0.5s ease both; }
        .logo { font-size: 1.6rem; font-weight: 900; color: #fff; letter-spacing: -0.5px; }
        .logo span { color: #F59E0B; }
        .logo-sub { font-size: 0.7rem; color: rgba(255,255,255,0.35); letter-spacing: 2px; text-transform: uppercase; }

        .auth-card { animation: cardIn 0.6s 0.1s ease both; }
        .auth-title { font-size: 1.6rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .auth-subtitle { color: rgba(255,255,255,0.45); font-size: 0.875rem; }

        .form-group { position: relative; }
        .form-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); font-size: 1rem; pointer-events: none; }
        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff; border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            transition: all 0.3s; font-size: 0.9rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08);
            border-color: #2563EB; color: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
            outline: none;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.2); }
        .form-label { color: rgba(255,255,255,0.6); font-size: 0.82rem; font-weight: 600; margin-bottom: 0.4rem; }

        .btn-login {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            border: none; border-radius: 12px; padding: 0.9rem;
            font-weight: 700; font-size: 1rem; color: #fff;
            position: relative; overflow: hidden; transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(37,99,235,0.35);
        }
        .btn-login::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(37,99,235,0.5); }
        .btn-login:hover::after { left: 100%; }

        .divider { color: rgba(255,255,255,0.15); text-align: center; position: relative; font-size: 0.8rem; }
        .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 40%; height: 1px; background: rgba(255,255,255,0.08); }
        .divider::before { left: 0; } .divider::after { right: 0; }

        .alert-danger-dark { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #FCA5A5; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.85rem; }

        .form-check-input:checked { background-color: #2563EB; border-color: #2563EB; }
        .form-check-label { color: rgba(255,255,255,0.45); font-size: 0.82rem; }
        a.link { color: #60A5FA; text-decoration: none; font-weight: 600; }
        a.link:hover { color: #93C5FD; }
        .back-link { color: rgba(255,255,255,0.3); font-size: 0.8rem; text-decoration: none; transition: color 0.2s; }
        .back-link:hover { color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>
    <!-- LEFT PANEL -->
    <div class="left-panel">
        <img src="/img/hero.png" alt="SportBook">
        <span class="float-emoji">⚽</span>
        <span class="float-emoji">🏸</span>
        <span class="float-emoji">🏀</span>
        <div class="left-panel-overlay">
            <h2>Kelola Booking<br>Lapangan Tanpa Ribet</h2>
            <p>Sistem reservasi real-time dengan jaminan <strong>0 double booking</strong>. Futsal, badminton, basket, dan banyak lagi.</p>
            <div class="feature-pills">
                <span class="feature-pill">⚡ Booking Instan</span>
                <span class="feature-pill">🛡️ Aman & Terjamin</span>
                <span class="feature-pill">📱 Mobile Friendly</span>
                <span class="feature-pill">📊 Laporan Realtime</span>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL — FORM -->
    <div class="right-panel">
        <div class="logo-wrap mb-4">
            <div class="logo">⚽ Sport<span>Book</span></div>
            <div class="logo-sub">Platform Reservasi Lapangan #1</div>
        </div>

        <div class="auth-card">
            <div class="mb-4">
                <h1 class="auth-title">Selamat Datang 👋</h1>
                <p class="auth-subtitle mt-1">Masuk untuk mulai booking lapangan olahraga</p>
            </div>

            @if($errors->any())
                <div class="alert-danger-dark mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach($errors->all() as $e) {{ $e }} @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <div class="form-group">
                        <i class="bi bi-envelope form-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="form-group">
                        <i class="bi bi-lock form-icon"></i>
                        <input type="password" name="password" id="pwd" class="form-control" placeholder="••••••••" required>
                        <button type="button" onclick="togglePwd()" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>
                <button type="submit" class="btn-login w-100 mb-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang
                </button>
            </form>

            <div class="divider mb-4">atau</div>
            <p class="text-center mb-4" style="font-size:0.875rem; color:rgba(255,255,255,0.45);">
                Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar gratis</a>
            </p>
            <div class="text-center">
                <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePwd() {
        const p = document.getElementById('pwd');
        const i = document.getElementById('eyeIcon');
        if (p.type === 'password') { p.type = 'text'; i.className = 'bi bi-eye-slash'; }
        else { p.type = 'password'; i.className = 'bi bi-eye'; }
    }
    </script>
</body>
</html>
