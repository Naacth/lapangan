@extends('layouts.app')

@section('title', $field->name . ' — SportBook')

@push('styles')
<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)} }
@keyframes shimmer { 0%{background-position:-200% center}100%{background-position:200% center} }
@keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)} }
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(1.3)} }

.field-hero {
    position: relative; min-height: 420px;
    display: flex; align-items: flex-end;
    overflow: hidden; padding-bottom: 2.5rem;
}
.field-hero-img {
    position: absolute; inset: 0;
    background: center/cover no-repeat;
}
.field-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(5,10,25,0.95) 30%, rgba(5,10,25,0.4) 70%, transparent);
}
.field-hero-content { position: relative; z-index: 2; }
.field-icon-badge { font-size: 4rem; animation: float 4s ease-in-out infinite; display: inline-block; filter: drop-shadow(0 8px 20px rgba(0,0,0,0.6)); }
.price-tag-glow {
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    color: #fff; border-radius: 14px; padding: 10px 22px;
    display: inline-block; box-shadow: 0 8px 24px rgba(37,99,235,0.4);
}
.live-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); color: #34D399; border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; font-weight: 700; }
.live-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #10B981; animation: pulse-dot 1.5s ease-in-out infinite; }
.info-card { background: #fff; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }

/* Slot buttons */
.availability-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(86px, 1fr)); gap: 8px; }
.slot-btn {
    border: 2px solid #E2E8F0; border-radius: 10px; padding: 9px 4px;
    text-align: center; font-size: 0.8rem; font-weight: 700;
    cursor: pointer; color: #0F172A; background: #fff;
    transition: all 0.25s; user-select: none; position: relative; overflow: hidden;
}
.slot-btn::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,#2563EB,#7C3AED); opacity:0; transition:opacity 0.2s; }
.slot-btn span { position: relative; z-index: 1; }
.slot-btn:hover:not(.booked) { border-color: #2563EB; color: #fff; }
.slot-btn:hover:not(.booked)::before { opacity: 1; }
.slot-btn.booked { background: #FEF2F2; border-color: #FECACA; color: #EF4444; cursor: not-allowed; }
.slot-btn.selected { border-color: #2563EB; color: #fff; }
.slot-btn.selected::before { opacity: 1; }

/* Booking summary card */
.booking-summary-card {
    background: linear-gradient(135deg, #0F172A, #1E3A5F);
    border-radius: 16px; padding: 1.5rem; color: #fff;
    border: 1px solid rgba(255,255,255,0.08);
}
.booking-summary-card .total-price { font-size: 1.8rem; font-weight: 900; background: linear-gradient(135deg, #60A5FA, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
</style>
@endpush

@section('content')
@php
    $imgMap = ['Futsal'=>'/img/futsal.png','Badminton'=>'/img/badminton.png','Basket'=>'/img/basket.png','Mini Soccer'=>'/img/minisoccer.png','Tenis'=>'/img/minisoccer.png','Voli'=>'/img/basket.png'];
    $emojiMap = ['Futsal'=>'⚽','Badminton'=>'🏸','Basket'=>'🏀','Mini Soccer'=>'🥅','Tenis'=>'🎾','Voli'=>'🏐'];
    $fieldImg = $imgMap[$field->sport_type] ?? '/img/hero.png';
    $fieldEmoji = $emojiMap[$field->sport_type] ?? '🏟️';
@endphp

{{-- Field Hero with Real Image --}}
<div class="field-hero">
    <div class="field-hero-img" style="background-image:url('{{ $fieldImg }}');"></div>
    <div class="field-hero-overlay"></div>
    <div class="container field-hero-content">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><span class="text-white-50">{{ $field->venue->name ?? '' }}</span></li>
                <li class="breadcrumb-item active text-white">{{ $field->name }}</li>
            </ol>
        </nav>
        <div class="row align-items-end g-3">
            <div class="col-auto">
                <div class="field-icon-badge">{{ $fieldEmoji }}</div>
            </div>
            <div class="col">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary">{{ $field->sport_type }}</span>
                    <span class="live-badge"><span class="dot"></span> Live Availability</span>
                </div>
                <h1 class="text-white fw-900 mb-1" style="font-size:2rem;">{{ $field->name }}</h1>
                <p class="text-white-50 mb-3"><i class="bi bi-building me-1"></i>{{ $field->venue->name ?? '' }} — {{ $field->venue->city ?? '' }}</p>
                <div class="price-tag-glow">
                    <span class="fw-900 fs-3">Rp {{ number_format($field->price_per_hour,0,',','.') }}</span>
                    <span class="text-white-75 small">/jam</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-7">

            {{-- Description --}}
            @if($field->description)
            <div class="info-card mb-4">
                <h5 class="fw-bold mb-2"><i class="bi bi-info-circle me-2 text-primary"></i>Tentang Lapangan</h5>
                <p class="text-muted mb-0">{{ $field->description }}</p>
            </div>
            @endif

            {{-- Schedules --}}
            @if($field->schedules->count())
            <div class="info-card mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-clock me-2 text-primary"></i>Jam Operasional</h5>
                <table class="table table-sm mb-0 schedule-table">
                    <tbody>
                    @php $days = ['monday'=>'Senin','tuesday'=>'Selasa','wednesday'=>'Rabu','thursday'=>'Kamis','friday'=>'Jumat','saturday'=>'Sabtu','sunday'=>'Minggu']; @endphp
                    @foreach($field->schedules as $schedule)
                    <tr>
                        <td class="text-muted" style="width:100px">{{ $days[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                        <td><strong>{{ substr($schedule->open_time, 0, 5) }} – {{ substr($schedule->close_time, 0, 5) }}</strong></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Availability Checker --}}
            <div class="info-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2 text-primary"></i>Cek Ketersediaan Slot</h5>
                <div class="mb-3">
                    <label class="form-label fw-600">Pilih Tanggal</label>
                    <input type="date" id="checkDate" class="form-control" min="{{ date('Y-m-d') }}">
                </div>
                <div id="slotsContainer" class="d-none">
                    <p class="text-muted small mb-2">Klik slot tersedia untuk melanjutkan booking</p>
                    <div class="availability-grid" id="slotsGrid"></div>
                </div>
                <div id="loadingSlots" class="d-none text-center py-3">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    <span class="ms-2 text-muted">Memeriksa ketersediaan...</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            {{-- Booking Form --}}
            <div class="info-card mb-4" id="bookingFormCard">
                <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2 text-success"></i>Buat Booking</h5>

                @guest
                    <div class="alert alert-info">
                        <i class="bi bi-lock me-2"></i> <a href="{{ route('login') }}">Login</a> atau <a href="{{ route('register') }}">daftar</a> terlebih dahulu untuk melakukan booking.
                    </div>
                @else
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="field_id" value="{{ $field->id }}">
                        <div class="mb-3">
                            <label class="form-label fw-600">Tanggal Bermain</label>
                            <input type="date" name="booking_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required id="formDate">
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label class="form-label fw-600">Mulai</label>
                                <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" id="formStart" required>
                            </div>
                            <div class="col">
                                <label class="form-label fw-600">Selesai</label>
                                <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" id="formEnd" required>
                            </div>
                        </div>
                        <div id="pricePreview" class="booking-summary mb-3 d-none">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50">Estimasi Total</small>
                                    <div class="fw-800 fs-4" id="priceDisplay">—</div>
                                </div>
                                <i class="bi bi-calculator fs-2 text-white-50"></i>
                            </div>
                            <div class="small text-white-50 mt-1" id="durationDisplay"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-700">
                            <i class="bi bi-calendar-plus me-2"></i> Buat Booking Sekarang
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const fieldId = {{ $field->id }};
const pricePerHour = {{ $field->price_per_hour }};

// Availability checker
document.getElementById('checkDate')?.addEventListener('change', function() {
    const date = this.value;
    if (!date) return;
    document.getElementById('loadingSlots').classList.remove('d-none');
    document.getElementById('slotsContainer').classList.add('d-none');

    fetch(`/fields/${fieldId}/availability?date=${date}`)
        .then(r => r.json())
        .then(data => {
            const bookedSlots = data.booked_slots.map(s => s.start_time.substring(0,5));
            const grid = document.getElementById('slotsGrid');
            grid.innerHTML = '';

            const hours = [];
            for (let h = 0; h < 24; h++) {
                hours.push(h.toString().padStart(2,'0') + ':00');
            }

            hours.forEach(slot => {
                const booked = bookedSlots.includes(slot);
                const btn = document.createElement('div');
                btn.className = 'slot-btn' + (booked ? ' booked' : '');
                // Format label: 00:00 = "00.00 (Tengah Malam)", 12:00 = "12.00 (Siang)", dll
                const h = parseInt(slot);
                let label = slot;
                if (h === 0)       label = '00.00\n(Tengah Malam)';
                else if (h === 12) label = '12.00\n(Siang)';
                btn.textContent = slot;
                btn.title = booked ? 'Sudah dipesan' : 'Tersedia';
                if (!booked) {
                    btn.onclick = () => {
                        document.getElementById('formDate').value = date;
                        document.getElementById('formStart').value = slot;
                        const endH = (parseInt(slot.split(':')[0]) + 1).toString().padStart(2,'0');
                        document.getElementById('formEnd').value = endH + ':00';
                        updatePrice();
                        document.getElementById('bookingFormCard').scrollIntoView({ behavior: 'smooth' });
                    };
                }
                grid.appendChild(btn);
            });

            document.getElementById('loadingSlots').classList.add('d-none');
            document.getElementById('slotsContainer').classList.remove('d-none');
        });
});

// Price preview
function updatePrice() {
    const start = document.getElementById('formStart').value;
    const end = document.getElementById('formEnd').value;
    if (!start || !end) return;

    const startH = parseInt(start.split(':')[0]);
    const endH = parseInt(end.split(':')[0]);
    const hours = Math.max(1, endH - startH);

    if (hours > 0) {
        const total = hours * pricePerHour;
        document.getElementById('pricePreview').classList.remove('d-none');
        document.getElementById('priceDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('durationDisplay').textContent = hours + ' jam × Rp ' + pricePerHour.toLocaleString('id-ID');
    }
}

document.getElementById('formStart')?.addEventListener('change', updatePrice);
document.getElementById('formEnd')?.addEventListener('change', updatePrice);
</script>
@endpush
