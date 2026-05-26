@extends('layouts.app')

@section('title', 'Detail Jurusan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👁️ Detail Jurusan</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $major->nama }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Jurusan</label>
                    <p class="form-control-plaintext">{{ $major->kode }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Jurusan</label>
                    <p class="form-control-plaintext">{{ $major->nama }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat Pada</label>
                    <p class="form-control-plaintext">{{ $major->created_at->format('d-m-Y H:i') }}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('majors.edit', $major->id) }}" class="btn btn-warning">✏️ Edit</a>
                    <form action="{{ route('majors.destroy', $major->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                    </form>
                    <a href="{{ route('majors.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
