@extends('layouts.app')
@section('title', 'Upload Bukti Bayar — SportBook')

@section('content')
<div style="background: linear-gradient(135deg, #0F172A, #1E293B); padding: 2.5rem 0; color: #fff;">
    <div class="container">
        <h1 class="fw-800 mb-1" style="font-size:1.8rem;"><i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran</h1>
        <p class="text-white-50 mb-0">Booking #{{ $booking->id }} · {{ $booking->field->name ?? '—' }}</p>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Booking Summary --}}
            <div class="card mb-4" style="border-radius:16px; border:none; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Ringkasan Booking</h5>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%">Lapangan</td>
                            <td class="fw-600">{{ $booking->field->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Venue</td>
                            <td class="fw-600">{{ $booking->field->venue->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal</td>
                            <td class="fw-600">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Waktu</td>
                            <td class="fw-600">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Bayar</td>
                            <td class="fw-800 text-primary fs-5">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Payment Instructions --}}
            <div class="alert alert-info mb-4" style="border-radius:12px;">
                <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Petunjuk Pembayaran</h6>
                <p class="mb-1 small">Transfer ke rekening berikut:</p>
                <ul class="mb-0 small">
                    <li>BCA: <strong>1234567890</strong> a/n SportBook Indonesia</li>
                    <li>Mandiri: <strong>0987654321</strong> a/n SportBook Indonesia</li>
                </ul>
                <p class="mt-2 mb-0 small">Setelah transfer, upload screenshot/foto bukti bayar di bawah ini.</p>
            </div>

            {{-- Upload Form --}}
            <div class="card" style="border-radius:16px; border:none; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-image me-2 text-primary"></i>Upload Bukti Transfer</h5>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                        </div>
                    @endif

                    <form action="{{ route('bookings.upload.post', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-600">Foto / Screenshot Bukti Bayar</label>
                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required id="proofInput" onchange="previewImage(this)">
                            <div class="form-text">Format: JPG, PNG. Maks: 2MB</div>
                        </div>
                        <div id="imagePreview" class="mb-4 d-none text-center">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height:250px; border: 2px dashed #2563EB;">
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-700">
                            <i class="bi bi-cloud-upload me-2"></i> Upload & Kirim ke Admin
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('bookings.history') }}" class="text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat Booking
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
