@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stat-card { background: #fff; border-radius: 16px; padding: 1.5rem; position: relative; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }
    .stat-card .bg-icon { position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.06; }
    .booking-row:hover { background: #F8FAFC; }
</style>
@endpush

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-calendar-check fs-4"></i></div>
                <span class="text-muted small fw-500">Booking Hari Ini</span>
            </div>
            <div class="stat-value">{{ $todayBookings }}</div>
            <div class="bg-icon">📅</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-hourglass-split fs-4"></i></div>
                <span class="text-muted small fw-500">Menunggu Verifikasi</span>
            </div>
            <div class="stat-value text-warning">{{ $pendingBookings }}</div>
            <div class="bg-icon">⏳</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-cash-stack fs-4"></i></div>
                <span class="text-muted small fw-500">Pendapatan Bulan Ini</span>
            </div>
            <div class="stat-value text-success" style="font-size:1.4rem;">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</div>
            <div class="bg-icon">💰</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-grid-3x3-gap fs-4"></i></div>
                <span class="text-muted small fw-500">Total Lapangan Aktif</span>
            </div>
            <div class="stat-value">{{ $totalFields }}</div>
            <div class="bg-icon">🏟️</div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-auto">
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-warning fw-600">
            <i class="bi bi-bell-fill me-2"></i> Booking Pending ({{ $pendingBookings }})
        </a>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.fields.create') }}" class="btn btn-primary fw-600">
            <i class="bi bi-plus-circle me-2"></i> Tambah Lapangan
        </a>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary fw-600">
            <i class="bi bi-bar-chart-line me-2"></i> Lihat Laporan
        </a>
    </div>
</div>

{{-- Recent Bookings --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Booking Terbaru</h5>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        @if($recentBookings->isEmpty())
            <div class="text-center py-4 text-muted"><i class="bi bi-calendar-x fs-1 d-block mb-2"></i>Belum ada booking</div>
        @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Lapangan</th>
                        <th>Tanggal & Jam</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr class="booking-row">
                        <td class="text-muted small">{{ $booking->id }}</td>
                        <td>
                            <div class="fw-600">{{ $booking->user->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <div class="fw-600">{{ $booking->field->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->field->venue->name ?? '' }}</div>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            <div class="text-muted small">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</div>
                        </td>
                        <td class="fw-700 text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td><span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
