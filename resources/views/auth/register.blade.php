<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — SportBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @keyframes gradientShift { 0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%} }
        @keyframes float { 0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-20px) rotate(5deg)} }
        @keyframes float2 { 0%,100%{transform:translateY(0)}50%{transform:translateY(-30px) rotate(-8deg)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)} }
        @keyframes cardIn { from{opacity:0;transform:translateY(40px) scale(0.95)}to{opacity:1;transform:translateY(0) scale(1)} }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { font-family:'Inter',sans-serif; background:#080d1a; min-height:100vh; display:flex; }

        .left-panel { flex:1; position:relative; overflow:hidden; display:none; }
        @media(min-width:992px) { .left-panel { display:flex; } }
        .left-panel img { width:100%; height:100%; object-fit:cover; filter:brightness(0.35); }
        .left-panel-overlay {
            position:absolute; inset:0;
            background:linear-gradient(135deg,rgba(16,185,129,0.6),rgba(37,99,235,0.5));
            display:flex; flex-direction:column; justify-content:flex-end; padding:3rem;
        }
        .left-panel-overlay h2 { color:#fff; font-size:2.2rem; font-weight:900; letter-spacing:-0.8px; line-height:1.2; }
        .left-panel-overlay p { color:rgba(255,255,255,0.7); margin-top:0.75rem; }
        .feature-pills { display:flex; flex-wrap:wrap; gap:8px; margin-top:1.5rem; }
        .feature-pill { background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#fff;border-radius:20px;padding:6px 14px;font-size:0.78rem;font-weight:600;border:1px solid rgba(255,255,255,0.2); }
        .float-emoji { position:absolute;font-size:3rem;opacity:0.15;pointer-events:none; }
        .float-emoji:nth-child(1) { top:10%; left:10%; animation:float 5s ease-in-out infinite; }
        .float-emoji:nth-child(2) { top:65%; left:80%; animation:float2 7s ease-in-out infinite; font-size:4rem; }
        .float-emoji:nth-child(3) { top:35%; left:55%; animation:float 6s ease-in-out infinite 1.5s; font-size:2.5rem; }

        .right-panel { width:100%; max-width:500px; background:#0F172A; display:flex; flex-direction:column; justify-content:center; padding:2.5rem; position:relative; overflow:hidden; overflow-y:auto; }
        @media(min-width:992px) { .right-panel { width:500px; flex-shrink:0; } }
        .right-panel::before { content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(16,185,129,0.1),transparent 70%);top:-100px;right:-100px;pointer-events:none; }

        .logo { font-size:1.6rem; font-weight:900; color:#fff; letter-spacing:-0.5px; }
        .logo span { color:#F59E0B; }
        .logo-sub { font-size:0.7rem; color:rgba(255,255,255,0.35); letter-spacing:2px; text-transform:uppercase; }

        .auth-title { font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-0.5px; }
        .auth-subtitle { color:rgba(255,255,255,0.45); font-size:0.875rem; }

        .form-group { position:relative; }
        .form-icon { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.3);font-size:1rem;pointer-events:none; }
        .form-control { background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);color:#fff;border-radius:12px;padding:0.8rem 1rem 0.8rem 2.75rem;transition:all 0.3s;font-size:0.9rem; }
        .form-control:focus { background:rgba(255,255,255,0.08);border-color:#10B981;color:#fff;box-shadow:0 0 0 4px rgba(16,185,129,0.15);outline:none; }
        .form-control::placeholder { color:rgba(255,255,255,0.2); }
        .form-label { color:rgba(255,255,255,0.6);font-size:0.82rem;font-weight:600;margin-bottom:0.4rem; }

        .btn-register { background:linear-gradient(135deg,#059669,#2563EB);border:none;border-radius:12px;padding:0.9rem;font-weight:700;font-size:1rem;color:#fff;position:relative;overflow:hidden;transition:all 0.3s;box-shadow:0 8px 24px rgba(16,185,129,0.3); }
        .btn-register::after { content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.15),transparent);transition:left 0.5s; }
        .btn-register:hover { transform:translateY(-2px); box-shadow:0 12px 36px rgba(16,185,129,0.45); }
        .btn-register:hover::after { left:100%; }

        .alert-danger-dark { background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#FCA5A5;border-radius:10px;padding:0.75rem 1rem;font-size:0.85rem; }
        a.link { color:#34D399;text-decoration:none;font-weight:600; }
        a.link:hover { color:#6EE7B7; }
        .back-link { color:rgba(255,255,255,0.3);font-size:0.8rem;text-decoration:none;transition:color 0.2s; }
        .back-link:hover { color:rgba(255,255,255,0.6); }
        .step-indicator { display:flex;gap:4px;margin-bottom:1.5rem; }
        .step-dot { height:4px;border-radius:2px;background:rgba(255,255,255,0.1);flex:1; }
        .step-dot.active { background:linear-gradient(90deg,#10B981,#2563EB); }
    </style>
</head>
<body>
    <div class="left-panel">
        <img src="/img/futsal.png" alt="SportBook">
        <span class="float-emoji">🥅</span>
        <span class="float-emoji">🏀</span>
        <span class="float-emoji">🎾</span>
        <div class="left-panel-overlay">
            <h2>Bergabung &amp;<br>Mulai Booking</h2>
            <p>Buat akun gratis dan mulai menikmati kemudahan booking lapangan olahraga online kapan saja, di mana saja.</p>
            <div class="feature-pills">
                <span class="feature-pill">✨ Gratis Daftar</span>
                <span class="feature-pill">🔒 Data Aman</span>
                <span class="feature-pill">⚡ Langsung Bisa Booking</span>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="mb-4" style="animation:fadeUp 0.5s ease both;">
            <div class="logo">⚽ Sport<span>Book</span></div>
            <div class="logo-sub">Platform Reservasi Lapangan #1</div>
        </div>

        <div style="animation:cardIn 0.6s 0.1s ease both;">
            <div class="mb-4">
                <h1 class="auth-title">Buat Akun Baru 🚀</h1>
                <p class="auth-subtitle mt-1">Daftar gratis dan langsung bisa booking lapangan favorit Anda</p>
            </div>

            @if($errors->any())
                <div class="alert-danger-dark mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <div class="form-group">
                        <i class="bi bi-person form-icon"></i>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap Anda" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                    <div class="form-group">
                        <i class="bi bi-envelope form-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon <span class="text-white-50 fw-400" style="font-weight:400;">(opsional)</span></label>
                    <div class="form-group">
                        <i class="bi bi-telephone form-icon"></i>
                        <input type="text" name="phone" class="form-control" placeholder="0812-xxxx-xxxx" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <i class="bi bi-lock form-icon"></i>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Konfirmasi <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <i class="bi bi-lock-fill form-icon"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-register w-100 mb-4">
                    <i class="bi bi-person-plus-fill me-2"></i> Buat Akun Sekarang
                </button>
            </form>

            <p class="text-center mb-3" style="font-size:0.875rem; color:rgba(255,255,255,0.45);">
                Sudah punya akun? <a href="{{ route('login') }}" class="link">Masuk di sini</a>
            </p>
            <div class="text-center">
                <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
