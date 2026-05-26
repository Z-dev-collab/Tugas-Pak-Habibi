@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👁️ Detail Kelas</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $classroom->nama }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kelas</label>
                    <p class="form-control-plaintext">{{ $classroom->nama }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tingkat</label>
                    <p class="form-control-plaintext">
                        <span class="badge bg-primary">Tingkat {{ $classroom->tingkat }}</span>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jurusan</label>
                    <p class="form-control-plaintext">{{ $classroom->major->nama }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah Siswa</label>
                    <p class="form-control-plaintext">{{ $classroom->students->count() }} siswa</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-warning">✏️ Edit</a>
                    <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                    </form>
                    <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
