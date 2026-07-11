@extends('layouts.admin')
@section('title', 'Laporan Pendapatan')
@section('page-title', 'Laporan Pendapatan')

@push('styles')
<style>
    .report-stat { background: #fff; border-radius: 16px; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }
</style>
@endpush

@section('content')
{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-3">
                <label class="form-label small fw-600 mb-1">Pilih Bulan</label>
                <input type="month" name="month" class="form-control form-control-sm" value="{{ $month }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Tampilkan</button>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.reports.export.csv', ['month' => $month]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i>Export CSV
                </a>
                <a href="{{ route('admin.reports.export.pdf', ['month' => $month]) }}" target="_blank" class="btn btn-sm btn-danger ms-1">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="report-stat text-center">
            <div class="text-muted small mb-1">Total Pendapatan</div>
            <div class="fw-800 text-success" style="font-size:2rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-muted small">Bulan {{ \Carbon\Carbon::parse($month)->format('F Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="report-stat text-center">
            <div class="text-muted small mb-1">Total Booking</div>
            <div class="fw-800 text-primary" style="font-size:2rem;">{{ $totalBookings }}</div>
            <div class="text-muted small">Confirmed & Completed</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="report-stat text-center">
            <div class="text-muted small mb-1">Rata-rata per Booking</div>
            <div class="fw-800 text-warning" style="font-size:2rem;">
                Rp {{ $totalBookings > 0 ? number_format($totalRevenue / $totalBookings, 0, ',', '.') : '0' }}
            </div>
            <div class="text-muted small">Average Revenue</div>
        </div>
    </div>
</div>

{{-- Revenue by Sport Type --}}
@if($revenueBySport->count())
<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Pendapatan per Jenis Olahraga</h6>
                @foreach($revenueBySport as $sport => $revenue)
                @php $pct = $totalRevenue > 0 ? ($revenue / $totalRevenue * 100) : 0; @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-600 small">{{ $sport }}</span>
                        <span class="text-primary fw-700 small">Rp {{ number_format($revenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar bg-primary" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Pendapatan per Hari ({{ \Carbon\Carbon::parse($month)->format('F Y') }})</h6>
                @if($revenueByDay->isEmpty())
                    <div class="text-center text-muted py-4"><i class="bi bi-bar-chart fs-1 d-block mb-2"></i>Tidak ada data</div>
                @else
                <div style="overflow-x:auto;">
                    <div class="d-flex align-items-end gap-1" style="height:160px; min-width:{{ $revenueByDay->count() * 28 }}px">
                        @php $maxRev = $revenueByDay->max() ?: 1; @endphp
                        @foreach($revenueByDay as $day => $rev)
                        @php $barH = max(4, ($rev / $maxRev) * 140); @endphp
                        <div class="text-center flex-fill" title="Tgl {{ $day }}: Rp {{ number_format($rev, 0, ',', '.') }}" style="cursor:pointer;">
                            <div style="height:{{ $barH }}px; background: linear-gradient(to top, #2563EB, #7C3AED); border-radius: 4px 4px 0 0;"></div>
                            <div style="font-size:0.6rem; color:#94A3B8; margin-top:2px;">{{ $day }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

{{-- Booking Table --}}
<div class="card">
    <div class="card-body p-0">
        <div class="p-4 pb-2">
            <h6 class="fw-bold mb-0">Detail Booking Bulan {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h6>
        </div>
        @if($bookings->isEmpty())
            <div class="text-center py-4 text-muted"><i class="bi bi-bar-chart fs-1 d-block mb-2"></i>Tidak ada data bulan ini</div>
        @else
        <div class="table-responsive">
            <table class="table align-middle table-sm mb-0">
                <thead class="table-light">
                    <tr><th>No</th><th>Customer</th><th>Lapangan</th><th>Tanggal</th><th>Waktu</th><th>Total</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($bookings as $i => $booking)
                    <tr>
                        <td class="text-muted small">{{ $i + 1 }}</td>
                        <td class="fw-600">{{ $booking->user->name ?? '—' }}</td>
                        <td>
                            <div>{{ $booking->field->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->field->sport_type ?? '' }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                        <td class="text-nowrap">
                            <i class="bi bi-clock text-muted me-1"></i>
                            {{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}
                        </td>
                        <td class="fw-700 text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td><span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="5" class="fw-700 text-end">TOTAL</td>
                        <td class="fw-800 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
