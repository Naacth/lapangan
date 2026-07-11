@extends('layouts.admin')
@section('title', 'Tambah Lapangan')
@section('page-title', 'Tambah Lapangan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Data Lapangan</h5>
                <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600">Venue <span class="text-danger">*</span></label>
                        <select name="venue_id" class="form-select" required>
                            <option value="">— Pilih Venue —</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->name }} ({{ $venue->city }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Lapangan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="cth: Lapangan Futsal A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Jenis Olahraga <span class="text-danger">*</span></label>
                        <select name="sport_type" class="form-select" required>
                            <option value="">— Pilih —</option>
                            @foreach(['Futsal','Badminton','Basket','Mini Soccer','Tenis','Voli'] as $type)
                                <option value="{{ $type }}" {{ old('sport_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Harga per Jam (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price_per_hour" class="form-control" value="{{ old('price_per_hour') }}" placeholder="150000" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi lapangan...">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-600">Foto Lapangan</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <div class="form-text">Format: JPG, PNG. Maks: 2MB</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-600"><i class="bi bi-plus-circle me-2"></i>Tambah Lapangan</button>
                        <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
