@extends('layouts.admin')
@section('title', 'Manajemen Lapangan')
@section('page-title', 'Manajemen Lapangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Semua Lapangan</h5>
        <small class="text-muted">{{ $fields->count() }} lapangan terdaftar</small>
    </div>
    <a href="{{ route('admin.fields.create') }}" class="btn btn-primary fw-600">
        <i class="bi bi-plus-circle me-2"></i> Tambah Lapangan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($fields->isEmpty())
            <div class="text-center py-5 text-muted"><i class="bi bi-grid-3x3-gap fs-1 d-block mb-2"></i>Belum ada lapangan. <a href="{{ route('admin.fields.create') }}">Tambah sekarang</a></div>
        @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Lapangan</th>
                        <th>Venue</th>
                        <th>Jenis Olahraga</th>
                        <th>Harga/Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fields as $field)
                    <tr>
                        <td>
                            <div class="fw-700">{{ $field->name }}</div>
                            @if($field->description)
                                <div class="text-muted small">{{ Str::limit($field->description, 50) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-600">{{ $field->venue->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $field->venue->city ?? '' }}</div>
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary fw-600">{{ $field->sport_type }}</span></td>
                        <td class="fw-700">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</td>
                        <td>
                            @if($field->is_active)
                                <span class="badge-confirmed"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>
                            @else
                                <span class="badge-cancelled"><i class="bi bi-x-circle-fill me-1"></i>Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.fields.edit', $field->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Hapus lapangan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
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
