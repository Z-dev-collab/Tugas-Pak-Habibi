@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>✏️ Edit Data Siswa</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS (Nomor Induk Siswa) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                                       id="nis" name="nis" value="{{ old('nis', $student->nis) }}" required>
                                <small class="text-muted">Tidak boleh sama dengan siswa lain</small>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama', $student->nama) }}" required>
                                <small class="text-muted">Minimal 3 karakter</small>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir->format('Y-m-d')) }}" required>
                                <small class="text-muted">Tidak boleh lebih dari hari ini</small>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="major_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-select @error('major_id') is-invalid @enderror" id="major_id" name="major_id" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" {{ old('major_id', $student->major_id) == $major->id ? 'selected' : '' }}>
                                            {{ $major->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('major_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="classroom_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select @error('classroom_id') is-invalid @enderror" id="classroom_id" name="classroom_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}" {{ old('classroom_id', $student->classroom_id) == $classroom->id ? 'selected' : '' }}>
                                            {{ $classroom->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classroom_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="badge bg-info">Opsional</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3">{{ old('alamat', $student->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP <span class="badge bg-info">Opsional</span></label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" name="no_hp" value="{{ old('no_hp', $student->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="aktif" {{ old('status', $student->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="lulus" {{ old('status', $student->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                    <option value="pindah" {{ old('status', $student->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                                    <option value="keluar" {{ old('status', $student->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">🔙 Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
