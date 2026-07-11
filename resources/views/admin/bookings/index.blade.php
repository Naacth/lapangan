@extends('layouts.admin')
@section('title', 'Manajemen Booking')
@section('page-title', 'Manajemen Booking')

@section('content')
{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-3">
                <label class="form-label small fw-600 mb-1">Filter Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(['pending','confirmed','rejected','cancelled','completed'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label class="form-label small fw-600 mb-1">Filter Tanggal</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
            <div class="col-auto ms-auto text-muted small align-self-end">
                {{ $bookings->total() }} booking ditemukan
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($bookings->isEmpty())
            <div class="text-center py-5 text-muted"><i class="bi bi-calendar-x fs-1 d-block mb-2"></i>Tidak ada booking ditemukan</div>
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
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="text-muted small">{{ $booking->id }}</td>
                        <td>
                            <div class="fw-600">{{ $booking->user->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->user->phone ?? '' }}</div>
                        </td>
                        <td>
                            <div class="fw-600">{{ $booking->field->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->field->sport_type ?? '' }}</div>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            <div class="text-muted small">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</div>
                        </td>
                        <td class="fw-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($booking->payment?->payment_proof)
                                <span class="text-success small"><i class="bi bi-check-circle-fill"></i> Ada</span>
                            @else
                                <span class="text-danger small"><i class="bi bi-x-circle"></i> Belum</span>
                            @endif
                        </td>
                        <td><span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $bookings->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
