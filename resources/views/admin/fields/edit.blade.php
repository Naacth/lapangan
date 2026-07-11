@extends('layouts.admin')
@section('title', 'Edit Lapangan')
@section('page-title', 'Edit Lapangan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Edit: {{ $field->name }}</h5>
                <form action="{{ route('admin.fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-600">Venue</label>
                        <select name="venue_id" class="form-select" required>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ $field->venue_id == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Lapangan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $field->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Jenis Olahraga <span class="text-danger">*</span></label>
                        <select name="sport_type" class="form-select" required>
                            @foreach(['Futsal','Badminton','Basket','Mini Soccer','Tenis','Voli'] as $type)
                                <option value="{{ $type }}" {{ $field->sport_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Harga per Jam (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price_per_hour" class="form-control" value="{{ old('price_per_hour', $field->price_per_hour) }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $field->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Foto Lapangan</label>
                        @if($field->photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($field->photo) }}" class="img-thumbnail" style="height:100px">
                                <div class="form-text">Foto saat ini. Upload baru untuk menggantinya.</div>
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $field->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-500" for="is_active">Lapangan Aktif (tersedia untuk booking)</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-600"><i class="bi bi-check-circle me-2"></i>Simpan Perubahan</button>
                        <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
