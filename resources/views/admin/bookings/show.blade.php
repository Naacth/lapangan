@extends('layouts.admin')
@section('title', 'Detail Booking #' . $booking->id)
@section('page-title', 'Detail Booking #' . $booking->id)

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Informasi Booking</h5>
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Customer</td>
                        <td>
                            <div class="fw-700">{{ $booking->user->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->user->email ?? '' }} · {{ $booking->user->phone ?? '' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Lapangan</td>
                        <td>
                            <div class="fw-700">{{ $booking->field->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $booking->field->venue->name ?? '' }} — {{ $booking->field->sport_type ?? '' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Bermain</td>
                        <td class="fw-600">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td class="fw-600">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }} WIB</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Pembayaran</td>
                        <td class="fw-800 fs-5 text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge-{{ $booking->status }} fs-6">{{ ucfirst($booking->status) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat Pada</td>
                        <td class="small">{{ $booking->created_at->format('d M Y, H:i') }} WIB</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Payment Proof --}}
        @if($booking->payment)
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Bukti Pembayaran</h5>

                {{-- Metode pembayaran --}}
                <div class="mb-3">
                    @if(($booking->payment->payment_method ?? 'transfer') === 'cash')
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="bi bi-cash-coin me-1"></i> Bayar di Tempat
                        </span>
                        <p class="text-muted small mt-2 mb-0">Customer memilih bayar langsung saat datang. Tidak ada bukti transfer.</p>
                    @else
                        <span class="badge bg-info text-dark fs-6">
                            <i class="bi bi-bank me-1"></i> Transfer Bank
                        </span>
                    @endif
                </div>

                @if(($booking->payment->payment_method ?? 'transfer') === 'cash')
                    {{-- Bayar di tempat: tidak perlu bukti --}}
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-clock me-2"></i>Konfirmasi booking ini setelah customer datang dan membayar.
                    </div>
                @elseif($booking->payment->payment_proof)
                    {{-- Coba Storage::url() dulu, fallback ke route storage-file --}}
                    @php
                        $imgUrl = file_exists(public_path('storage/' . $booking->payment->payment_proof))
                            ? asset('storage/' . $booking->payment->payment_proof)
                            : route('storage.file', urlencode($booking->payment->payment_proof));
                    @endphp
                    <img src="{{ $imgUrl }}"
                         class="img-fluid rounded mb-3"
                         style="max-height:350px; border:2px solid #E2E8F0; cursor:pointer;"
                         onclick="window.open(this.src,'_blank')"
                         title="Klik untuk buka gambar penuh"
                         onerror="this.src='{{ route('storage.file', urlencode($booking->payment->payment_proof)) }}'">
                    <div class="text-muted small mb-3">
                        <i class="bi bi-zoom-in me-1"></i>Klik gambar untuk memperbesar
                    </div>
                @else
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-hourglass me-2"></i>Customer belum upload bukti pembayaran.
                    </div>
                @endif

                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Status Pembayaran</td>
                        <td><span class="badge-{{ $booking->payment->status ?? 'pending' }}">{{ ucfirst($booking->payment->status ?? 'pending') }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode</td>
                        <td class="fw-600">
                            @if(($booking->payment->payment_method ?? 'transfer') === 'cash')
                                <i class="bi bi-cash-coin text-warning me-1"></i>Bayar di Tempat
                            @else
                                <i class="bi bi-bank text-info me-1"></i>Transfer Bank
                            @endif
                        </td>
                    </tr>
                    @if($booking->payment->verified_at)
                    <tr>
                        <td class="text-muted">Diverifikasi Pada</td>
                        <td class="small">{{ \Carbon\Carbon::parse($booking->payment->verified_at)->format('d M Y, H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Update Status Booking</h5>
                <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600">Pilih Status Baru</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending' => 'Pending (Menunggu)', 'confirmed' => 'Confirmed (Konfirmasi)', 'rejected' => 'Rejected (Tolak)', 'cancelled' => 'Cancelled (Batalkan)', 'completed' => 'Completed (Selesai)'] as $val => $label)
                                <option value="{{ $val }}" {{ $booking->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i>
                        Saat status diubah ke <strong>Confirmed</strong>, bukti pembayaran otomatis ditandai terverifikasi.
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-600">
                        <i class="bi bi-arrow-repeat me-2"></i> Update Status
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    <a href="{{ route('admin.bookings.index') }}" class="text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
