@extends('layouts.app')

@section('title', 'SportBook — Reservasi Lapangan Olahraga Online')
@section('description', 'Temukan dan booking lapangan olahraga impian Anda dengan mudah. Futsal, badminton, basket, mini soccer, dan tenis.')

@push('styles')
<style>
/* ========= ANIMATIONS ========= */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; } to { opacity: 1; }
}
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33%       { transform: translateY(-18px) rotate(5deg); }
    66%       { transform: translateY(-8px) rotate(-3deg); }
}
@keyframes float2 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50%       { transform: translateY(-24px) rotate(-8deg); }
}
@keyframes gradientShift {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
@keyframes pulse-ring {
    0%   { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(2.2); opacity: 0; }
}
@keyframes countUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
}
@keyframes slideInLeft { from { opacity:0; transform: translateX(-40px); } to { opacity:1; transform: translateX(0); } }
@keyframes slideInRight { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform: translateX(0); } }
@keyframes scaleIn { from { opacity:0; transform: scale(0.85); } to { opacity:1; transform: scale(1); } }
@keyframes borderGlow {
    0%, 100% { box-shadow: 0 0 15px rgba(37,99,235,0.4); }
    50%       { box-shadow: 0 0 35px rgba(124,58,237,0.6), 0 0 60px rgba(37,99,235,0.3); }
}

/* ========= HERO ========= */
.hero {
    position: relative; min-height: 100vh;
    display: flex; align-items: center;
    overflow: hidden;
    background: linear-gradient(-45deg, #0a0e1a, #0f172a, #0d1b3e, #0a1628);
    background-size: 400% 400%;
    animation: gradientShift 10s ease infinite;
    padding: 5rem 0 4rem;
}
.hero-bg-img {
    position: absolute; inset: 0;
    background: url('/img/hero.png') center/cover no-repeat;
    opacity: 0.15;
    filter: blur(2px);
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to right, rgba(10,14,26,0.97) 40%, rgba(10,14,26,0.5));
}
.hero-grid-lines {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(37,99,235,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(37,99,235,0.06) 1px, transparent 1px);
    background-size: 60px 60px;
}

/* Floating sport balls */
.float-ball {
    position: absolute; user-select: none; pointer-events: none;
    font-size: 3.5rem; opacity: 0.08;
    animation: float 6s ease-in-out infinite;
}
.float-ball:nth-child(1) { top: 10%; left: 75%; animation-delay: 0s; font-size: 4.5rem; opacity: 0.12; }
.float-ball:nth-child(2) { top: 60%; left: 85%; animation: float2 7s ease-in-out infinite; animation-delay: 1s; opacity: 0.07; }
.float-ball:nth-child(3) { top: 25%; left: 90%; animation-delay: 2s; font-size: 3rem; opacity: 0.09; }
.float-ball:nth-child(4) { top: 80%; left: 70%; animation-delay: 0.5s; font-size: 5rem; opacity: 0.06; }
.float-ball:nth-child(5) { top: 45%; left: 78%; animation: float2 8s ease-in-out infinite; font-size: 2.8rem; opacity: 0.1; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(37,99,235,0.15);
    border: 1px solid rgba(37,99,235,0.4);
    color: #93C5FD; border-radius: 30px;
    padding: 7px 20px; font-size: 0.82rem; font-weight: 600;
    animation: fadeUp 0.6s ease both;
    backdrop-filter: blur(8px);
}
.hero-badge .dot {
    width: 8px; height: 8px; border-radius: 50%; background: #10B981;
    position: relative;
}
.hero-badge .dot::before {
    content: ''; position: absolute; inset: -3px;
    border-radius: 50%; background: #10B981;
    animation: pulse-ring 1.5s ease-out infinite;
}

.hero h1 {
    font-size: clamp(2.2rem, 5.5vw, 4rem);
    font-weight: 900; color: #fff;
    line-height: 1.1; letter-spacing: -1.5px;
    animation: fadeUp 0.7s 0.1s ease both;
}
.hero h1 .gradient-text {
    background: linear-gradient(135deg, #60A5FA, #A78BFA, #F472B6);
    background-size: 200% auto;
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    animation: shimmer 3s linear infinite;
}

.hero-desc { color: rgba(255,255,255,0.6); font-size: 1.1rem; line-height: 1.7; animation: fadeUp 0.7s 0.2s ease both; }

.btn-hero-primary {
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    border: none; border-radius: 14px; padding: 14px 32px;
    font-weight: 700; font-size: 1rem; color: #fff;
    transition: all 0.3s; position: relative; overflow: hidden;
    animation: fadeUp 0.7s 0.3s ease both;
    box-shadow: 0 8px 30px rgba(37,99,235,0.4);
}
.btn-hero-primary::before {
    content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s;
}
.btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(37,99,235,0.5); color: #fff; }
.btn-hero-primary:hover::before { left: 100%; }

.btn-hero-outline {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 14px; padding: 14px 32px;
    font-weight: 600; color: #fff;
    backdrop-filter: blur(8px);
    transition: all 0.3s;
    animation: fadeUp 0.7s 0.35s ease both;
}
.btn-hero-outline:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.4); color: #fff; transform: translateY(-2px); }

.hero-stats {
    display: flex; gap: 2.5rem; flex-wrap: wrap;
    animation: fadeUp 0.7s 0.4s ease both;
}
.stat-item { position: relative; }
.stat-item .num {
    font-size: 2rem; font-weight: 900; color: #fff; display: block;
    line-height: 1;
}
.stat-item .label { font-size: 0.75rem; color: rgba(255,255,255,0.45); font-weight: 500; }
.stat-divider { width: 1px; background: rgba(255,255,255,0.1); align-self: stretch; }

/* ========= FIELDS SECTION ========= */
.section-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: #EFF6FF; color: #2563EB;
    border-radius: 20px; padding: 5px 14px;
    font-size: 0.78rem; font-weight: 700; letter-spacing: 0.5px;
    text-transform: uppercase;
}
.section-title { font-size: 2.2rem; font-weight: 900; color: #0F172A; letter-spacing: -0.8px; }

/* ========= SPORT CARD ========= */
.sport-card {
    border: none; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer; background: #fff;
}
.sport-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    animation: borderGlow 2s ease-in-out infinite;
}
.sport-card .img-wrapper {
    position: relative; height: 180px; overflow: hidden;
}
.sport-card .img-wrapper img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.6s ease;
}
.sport-card:hover .img-wrapper img { transform: scale(1.1); }
.sport-card .img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
}
.sport-card .img-wrapper .sport-emoji {
    position: absolute; top: 12px; right: 14px;
    font-size: 2rem; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.5));
}
.sport-card .sport-type-pill {
    position: absolute; bottom: 12px; left: 12px;
    background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);
    color: #fff; border-radius: 20px; padding: 4px 12px;
    font-size: 0.72rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.3);
}
.sport-card .card-body { padding: 1.25rem; }
.sport-card .venue-loc { font-size: 0.72rem; color: #94A3B8; font-weight: 500; display: flex; align-items: center; gap: 4px; }
.sport-card .field-name { font-weight: 800; font-size: 1rem; color: #0F172A; margin: 4px 0 6px; }
.sport-card .price { color: #2563EB; font-weight: 900; font-size: 1.05rem; }
.sport-card .price small { color: #94A3B8; font-weight: 400; font-size: 0.75rem; }
.sport-card .book-btn {
    display: block; text-align: center;
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    color: #fff; border-radius: 10px;
    padding: 8px; font-size: 0.82rem; font-weight: 700;
    margin-top: 12px; transition: all 0.3s;
    text-decoration: none;
}
.sport-card .book-btn:hover { opacity: 0.9; transform: translateY(-1px); }

/* Reveal animations */
[data-reveal] { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
[data-reveal].revealed { opacity: 1; transform: none; }

/* ========= HOW IT WORKS ========= */
.how-section {
    background: linear-gradient(135deg, #0F172A, #0d1b3e);
    padding: 6rem 0; position: relative; overflow: hidden;
}
.how-section::before {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(37,99,235,0.1) 0%, transparent 50%),
                      radial-gradient(circle at 80% 20%, rgba(124,58,237,0.1) 0%, transparent 50%);
}
.step-card {
    text-align: center; padding: 2rem 1rem;
    transition: transform 0.3s;
}
.step-card:hover { transform: translateY(-5px); }
.step-num-wrap { position: relative; display: inline-flex; justify-content: center; align-items: center; margin-bottom: 1.25rem; }
.step-num {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    border-radius: 50%; color: #fff; font-weight: 900; font-size: 1.3rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 24px rgba(37,99,235,0.4); position: relative; z-index: 1;
}
.step-num-wrap::before {
    content: ''; position: absolute;
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(37,99,235,0.15); z-index: 0;
}
.step-icon { font-size: 2rem; display: block; margin-bottom: 0.5rem; }
.step-card h5 { color: #fff; font-weight: 700; font-size: 1rem; }
.step-card p { color: rgba(255,255,255,0.5); font-size: 0.85rem; }
.step-connector { display: flex; align-items: center; justify-content: center; padding-top: 1.5rem; }
.step-connector::before { content: '→'; color: rgba(255,255,255,0.2); font-size: 1.5rem; }

/* ========= FEATURES STRIP ========= */
.features-strip { background: #fff; padding: 2rem 0; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; }
.feature-item { display: flex; align-items: center; gap: 12px; padding: 0.75rem 0; }
.feature-item .fi { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
.feature-item h6 { margin: 0; font-weight: 700; font-size: 0.9rem; color: #0F172A; }
.feature-item p { margin: 0; font-size: 0.78rem; color: #64748B; }

/* ========= CTA ========= */
.cta-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #2563EB, #7C3AED, #EC4899);
    background-size: 300% 300%;
    animation: gradientShift 8s ease infinite;
    position: relative; overflow: hidden;
}
.cta-section::before {
    content: '';position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='40' cy='40' r='3'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>
@endpush

@section('content')
<!-- HERO -->
<section class="hero">
    <div class="hero-bg-img"></div>
    <div class="hero-overlay"></div>
    <div class="hero-grid-lines"></div>

    <!-- Floating balls -->
    <div class="float-ball">⚽</div>
    <div class="float-ball">🏸</div>
    <div class="float-ball">🏀</div>
    <div class="float-ball">🥅</div>
    <div class="float-ball">🎾</div>

    <div class="container position-relative">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7">
                <div class="hero-badge mb-4">
                    <span class="dot"></span>
                    Real-Time · Bebas Double Booking
                </div>
                <h1 class="mb-4">
                    Booking Lapangan<br>
                    Olahraga Jadi<br>
                    <span class="gradient-text">Lebih Mudah</span>
                </h1>
                <p class="hero-desc mb-5">
                    Pilih lapangan, cek ketersediaan <strong style="color:#93C5FD">real-time</strong>, dan booking dalam hitungan menit.
                    Mulai dari futsal, badminton, basket hingga mini soccer — semua ada di sini.
                </p>
                <div class="d-flex gap-3 flex-wrap mb-5">
                    <a href="#venues" class="btn-hero-primary">
                        <i class="bi bi-search me-2"></i> Temukan Lapangan
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-hero-outline">
                            <i class="bi bi-lightning-charge me-2"></i> Daftar Gratis
                        </a>
                    @endguest
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="num" data-count="5">0</span>
                        <span class="label">Lapangan Aktif</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="num" data-count="2">0</span>
                        <span class="label">Venue Partner</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="num">100%</span>
                        <span class="label">Anti Double Booking</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div style="position:relative; animation: scaleIn 0.8s 0.4s ease both; opacity:0; animation-fill-mode:forwards;">
                    <img src="/img/hero.png" alt="SportBook Arena" class="img-fluid rounded-4"
                         style="box-shadow: 0 30px 80px rgba(37,99,235,0.3); border: 1px solid rgba(255,255,255,0.1);">
                    <div style="position:absolute; top:-12px; right:-12px; background:linear-gradient(135deg,#10B981,#059669); color:#fff; border-radius:14px; padding:10px 18px; font-weight:800; font-size:0.9rem; box-shadow: 0 8px 24px rgba(16,185,129,0.4);">
                        ✓ Slot Tersedia
                    </div>
                    <div style="position:absolute; bottom:-16px; left:20px; background:#1E293B; border:1px solid rgba(255,255,255,0.1); color:#fff; border-radius:14px; padding:12px 18px; backdrop-filter:blur(8px);">
                        <div style="font-size:0.7rem; color:#94A3B8;">Booking Terbaru</div>
                        <div style="font-weight:700; font-size:0.9rem;">⚽ Futsal A — 19:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES STRIP -->
<div class="features-strip">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="feature-item">
                    <div class="fi" style="background:#EFF6FF; color:#2563EB;"><i class="bi bi-lightning-charge-fill"></i></div>
                    <div><h6>Booking Instan</h6><p>Konfirmasi dalam hitungan detik</p></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-item">
                    <div class="fi" style="background:#F0FDF4; color:#10B981;"><i class="bi bi-shield-check-fill"></i></div>
                    <div><h6>Aman & Terpercaya</h6><p>0% kasus double booking</p></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-item">
                    <div class="fi" style="background:#FFF7ED; color:#F59E0B;"><i class="bi bi-calendar3"></i></div>
                    <div><h6>Slot Real-Time</h6><p>Cek ketersediaan langsung</p></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-item">
                    <div class="fi" style="background:#F5F3FF; color:#7C3AED;"><i class="bi bi-phone"></i></div>
                    <div><h6>Mobile Friendly</h6><p>Bisa booking dari HP</p></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- VENUES & FIELDS -->
<section class="py-5 bg-light" id="venues">
    <div class="container">
        <div class="text-center mb-5" data-reveal>
            <div class="section-badge mb-3"><i class="bi bi-grid-3x3-gap-fill me-1"></i> Lapangan Tersedia</div>
            <h2 class="section-title">Pilih Lapangan Favorit Anda</h2>
            <p class="text-muted" style="max-width:500px;margin:auto;">Tersedia berbagai jenis olahraga di lokasi-lokasi strategis dengan fasilitas premium</p>
        </div>

        @foreach($venues as $vi => $venue)
        <div class="mb-5" data-reveal style="transition-delay: {{ $vi * 0.1 }}s">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background:linear-gradient(135deg,#2563EB,#7C3AED); width:42px; height:42px; border-radius:10px; display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;flex-shrink:0;"><i class="bi bi-building"></i></div>
                <div>
                    <h4 class="fw-900 mb-0" style="font-weight:800;">{{ $venue->name }}</h4>
                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $venue->address }}, <strong>{{ $venue->city }}</strong></small>
                </div>
            </div>

            @if($venue->fields->where('is_active', true)->count())
            <div class="row g-3">
                @php
                    $imgMap = ['Futsal'=>'/img/futsal.png','Badminton'=>'/img/badminton.png','Basket'=>'/img/basket.png','Mini Soccer'=>'/img/minisoccer.png','Tenis'=>'/img/minisoccer.png','Voli'=>'/img/basket.png'];
                    $emojiMap = ['Futsal'=>'⚽','Badminton'=>'🏸','Basket'=>'🏀','Mini Soccer'=>'🥅','Tenis'=>'🎾','Voli'=>'🏐'];
                @endphp
                @foreach($venue->fields->where('is_active', true) as $fi => $field)
                <div class="col-6 col-md-4 col-lg-3" data-reveal style="transition-delay: {{ ($vi * 4 + $fi) * 0.08 }}s">
                    <a href="{{ route('fields.show', $field->id) }}" class="text-decoration-none">
                        <div class="sport-card">
                            <div class="img-wrapper">
                                <img src="{{ $imgMap[$field->sport_type] ?? '/img/hero.png' }}" alt="{{ $field->name }}" loading="lazy">
                                <div class="img-overlay"></div>
                                <span class="sport-emoji">{{ $emojiMap[$field->sport_type] ?? '🏟️' }}</span>
                                <span class="sport-type-pill">{{ $field->sport_type }}</span>
                            </div>
                            <div class="card-body">
                                <div class="venue-loc"><i class="bi bi-geo-alt-fill"></i> {{ $venue->city }}</div>
                                <div class="field-name">{{ $field->name }}</div>
                                @if($field->description)
                                    <div class="text-muted mb-2" style="font-size:0.73rem;line-height:1.4;">{{ Str::limit($field->description, 55) }}</div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="price">Rp {{ number_format($field->price_per_hour,0,',','.') }}<small>/jam</small></div>
                                </div>
                                <div class="book-btn mt-2">Lihat & Booking →</div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
    <div class="container position-relative">
        <div class="text-center mb-5" data-reveal>
            <div class="section-badge mb-3" style="background:rgba(37,99,235,0.15);color:#93C5FD;"><i class="bi bi-lightning me-1"></i>Mudah &amp; Cepat</div>
            <h2 class="fw-900 text-white" style="font-size:2rem; letter-spacing:-0.5px;">Cara Booking dalam 4 Langkah</h2>
            <p class="text-white-50">Proses reservasi yang simpel, transparan, dan terdokumentasi</p>
        </div>
        <div class="row g-4">
            <div class="col-6 col-md-3" data-reveal style="transition-delay:0s">
                <div class="step-card">
                    <div class="step-num-wrap mb-3"><div class="step-num">1</div></div>
                    <i class="bi bi-search" style="font-size:2.2rem;color:#60A5FA;margin-bottom:0.75rem;display:block;"></i>
                    <h5>Pilih Lapangan</h5>
                    <p>Cari venue dan lapangan sesuai jenis olahraga &amp; lokasi Anda.</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-reveal style="transition-delay:0.12s">
                <div class="step-card">
                    <div class="step-num-wrap mb-3"><div class="step-num">2</div></div>
                    <i class="bi bi-calendar3" style="font-size:2.2rem;color:#A78BFA;margin-bottom:0.75rem;display:block;"></i>
                    <h5>Pilih Jadwal</h5>
                    <p>Cek slot jam secara real-time dan pilih waktu yang tersedia.</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-reveal style="transition-delay:0.24s">
                <div class="step-card">
                    <div class="step-num-wrap mb-3"><div class="step-num">3</div></div>
                    <i class="bi bi-credit-card" style="font-size:2.2rem;color:#34D399;margin-bottom:0.75rem;display:block;"></i>
                    <h5>Bayar Transfer</h5>
                    <p>Lakukan transfer dan upload bukti pembayaran di aplikasi.</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-reveal style="transition-delay:0.36s">
                <div class="step-card">
                    <div class="step-num-wrap mb-3"><div class="step-num">4</div></div>
                    <i class="bi bi-trophy" style="font-size:2.2rem;color:#FBBF24;margin-bottom:0.75rem;display:block;"></i>
                    <h5>Siap Bermain!</h5>
                    <p>Admin verifikasi dan booking Anda dikonfirmasi. Have fun!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
@guest
<section class="cta-section">
    <div class="container position-relative text-center" data-reveal>
        <h2 class="fw-900 text-white mb-3" style="font-size:2.2rem;">Siap Booking Lapangan Pertama Anda? 🚀</h2>
        <p class="text-white mb-5" style="opacity:0.8; font-size:1.1rem;">Daftar gratis sekarang dan nikmati kemudahan booking lapangan olahraga online</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light fw-700 btn-lg px-5 py-3" style="border-radius:14px; color:#2563EB;">
                <i class="bi bi-person-plus-fill me-2"></i> Daftar Gratis Sekarang
            </a>
            <a href="#venues" class="btn btn-outline-light fw-600 btn-lg px-5 py-3" style="border-radius:14px;">
                <i class="bi bi-search me-2"></i> Lihat Lapangan
            </a>
        </div>
    </div>
</section>
@endguest

@endsection

@push('scripts')
<script>
// Scroll reveal animation
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));

// Count-up animation for hero stats
function animateCount(el, target) {
    let start = 0;
    const duration = 2000;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { el.textContent = target + '+'; clearInterval(timer); }
        else { el.textContent = Math.floor(start); }
    }, 16);
}

setTimeout(() => {
    document.querySelectorAll('[data-count]').forEach(el => {
        animateCount(el, parseInt(el.dataset.count));
    });
}, 600);

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});
</script>
@endpush
