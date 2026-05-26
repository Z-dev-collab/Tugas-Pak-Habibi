@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>✏️ Edit Kelas</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama', $classroom->nama) }}" required>
                        <small class="text-muted">Minimal 3 karakter</small>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                        <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="1" {{ old('tingkat', $classroom->tingkat) == 1 ? 'selected' : '' }}>Tingkat 1</option>
                            <option value="2" {{ old('tingkat', $classroom->tingkat) == 2 ? 'selected' : '' }}>Tingkat 2</option>
                            <option value="3" {{ old('tingkat', $classroom->tingkat) == 3 ? 'selected' : '' }}>Tingkat 3</option>
                            <option value="4" {{ old('tingkat', $classroom->tingkat) == 4 ? 'selected' : '' }}>Tingkat 4</option>
                            <option value="5" {{ old('tingkat', $classroom->tingkat) == 5 ? 'selected' : '' }}>Tingkat 5</option>
                            <option value="6" {{ old('tingkat', $classroom->tingkat) == 6 ? 'selected' : '' }}>Tingkat 6</option>
                        </select>
                        @error('tingkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="major_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select class="form-select @error('major_id') is-invalid @enderror" id="major_id" name="major_id" required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_id', $classroom->major_id) == $major->id ? 'selected' : '' }}>
                                    {{ $major->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('major_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
