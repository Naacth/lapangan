@extends('layouts.app')
@section('title', 'Riwayat Booking — SportBook')

@push('styles')
<style>
    .booking-card { border: none; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); transition: all .2s; }
    .booking-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); transform: translateY(-2px); }
    .booking-header { background: linear-gradient(135deg, #0F172A, #1E3A5F); color: #fff; border-radius: 16px 16px 0 0; padding: 1.25rem 1.5rem; }
    .status-badge { border-radius: 20px; padding: 5px 14px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
    .status-pending { background: #FEF3C7; color: #92400E; }
    .status-confirmed { background: #D1FAE5; color: #065F46; }
    .status-rejected, .status-cancelled { background: #FEE2E2; color: #991B1B; }
    .status-completed { background: #EDE9FE; color: #4C1D95; }
    .hero-mini { background: linear-gradient(135deg, #0F172A, #1E293B); padding: 2.5rem 0; color: #fff; }
</style>
@endpush

@section('content')
<div class="hero-mini">
    <div class="container">
        <h1 class="fw-800 mb-1" style="font-size:1.8rem;"><i class="bi bi-calendar-check me-2"></i>Riwayat Booking Saya</h1>
        <p class="text-white-50 mb-0">Semua pesanan lapangan olahraga Anda</p>
    </div>
</div>

<div class="container py-4">
    @if($bookings->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem;">📋</div>
            <h4 class="fw-bold mt-3">Belum Ada Booking</h4>
            <p class="text-muted">Anda belum pernah melakukan reservasi lapangan.</p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4"><i class="bi bi-search me-2"></i> Cari Lapangan</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($bookings as $booking)
            @php
                $statusMap = [
                    'pending' => ['icon' => 'hourglass-split', 'label' => 'Menunggu Bayar'],
                    'confirmed' => ['icon' => 'check-circle-fill', 'label' => 'Dikonfirmasi'],
                    'rejected' => ['icon' => 'x-circle-fill', 'label' => 'Ditolak'],
                    'cancelled' => ['icon' => 'x-circle', 'label' => 'Dibatalkan'],
                    'completed' => ['icon' => 'trophy-fill', 'label' => 'Selesai'],
                ];
                $st = $statusMap[$booking->status] ?? ['icon' => 'question-circle', 'label' => $booking->status];
            @endphp
            <div class="col-lg-6">
                <div class="booking-card card">
                    <div class="booking-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-700 mb-1">{{ $booking->field->name ?? '—' }}</div>
                                <div class="text-white-50 small"><i class="bi bi-building me-1"></i>{{ $booking->field->venue->name ?? '—' }}</div>
                            </div>
                            <span class="status-badge status-{{ $booking->status }}">
                                <i class="bi bi-{{ $st['icon'] }}"></i> {{ $st['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="text-muted small">Tanggal Bermain</div>
                                <div class="fw-700">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">Waktu</div>
                                <div class="fw-700">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">Total Bayar</div>
                                <div class="fw-800 text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">Bukti Bayar</div>
                                <div class="fw-600">
                                    @if($booking->payment?->payment_proof)
                                        <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Uploaded</span>
                                    @else
                                        <span class="text-danger"><i class="bi bi-x-circle me-1"></i>Belum diupload</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            @if($booking->status === 'pending' && !$booking->payment?->payment_proof)
                                <a href="{{ route('bookings.upload', $booking->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-upload me-1"></i> Upload Bukti Bayar
                                </a>
                            @endif
                            @if($booking->status === 'pending')
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle me-1"></i> Batalkan</button>
                                </form>
                            @endif
                            <small class="text-muted ms-auto align-self-center">Dibuat {{ $booking->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
