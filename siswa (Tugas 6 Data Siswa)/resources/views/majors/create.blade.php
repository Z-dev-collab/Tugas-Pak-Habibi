@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>➕ Tambah Jurusan Baru</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('majors.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                               id="kode" name="kode" value="{{ old('kode') }}" required>
                        <small class="text-muted">Minimal 2 karakter, tidak boleh sama</small>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama') }}" required>
                        <small class="text-muted">Minimal 3 karakter</small>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                        <a href="{{ route('majors.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
