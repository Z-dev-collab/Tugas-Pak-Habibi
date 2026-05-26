@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👁️ Detail Siswa</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $student->nama }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">NIS</label>
                        <p class="form-control-plaintext">{{ $student->nis }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <p class="form-control-plaintext">{{ $student->nama }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <p class="form-control-plaintext">
                            @if ($student->jenis_kelamin == 'L')
                                <span class="badge bg-primary">Laki-laki</span>
                            @else
                                <span class="badge bg-danger">Perempuan</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <p class="form-control-plaintext">{{ $student->tanggal_lahir->format('d-m-Y') }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jurusan</label>
                        <p class="form-control-plaintext">{{ $student->major->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kelas</label>
                        <p class="form-control-plaintext">{{ $student->classroom->nama }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <p class="form-control-plaintext">
                        @if ($student->alamat)
                            {{ $student->alamat }}
                        @else
                            <span class="text-muted fst-italic">-</span>
                        @endif
                    </p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nomor HP</label>
                        <p class="form-control-plaintext">
                            @if ($student->no_hp)
                                {{ $student->no_hp }}
                            @else
                                <span class="text-muted fst-italic">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <p class="form-control-plaintext">
                            @if ($student->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif ($student->status == 'lulus')
                                <span class="badge bg-info">Lulus</span>
                            @elseif ($student->status == 'pindah')
                                <span class="badge bg-warning">Pindah</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">✏️ Edit</a>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                    </form>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
