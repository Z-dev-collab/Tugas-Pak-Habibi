@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>👥 Daftar Siswa</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary">+ Tambah Siswa</a>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('students.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari NIS atau Nama..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="major_id" class="form-select">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach ($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
                            {{ $major->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="classroom_id" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">🔍 Cari</button>
            </div>
        </form>
        @if (request('search') || request('major_id') || request('classroom_id'))
            <div class="mt-2">
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">🔄 Reset Filter</a>
                <small class="text-muted">
                    @if (request('search'))
                        Pencarian: <strong>{{ request('search') }}</strong>
                    @endif
                    @if (request('major_id'))
                        | Jurusan: <strong>{{ $majors->find(request('major_id'))->nama ?? 'N/A' }}</strong>
                    @endif
                    @if (request('classroom_id'))
                        | Kelas: <strong>{{ $classrooms->find(request('classroom_id'))->nama ?? 'N/A' }}</strong>
                    @endif
                </small>
            </div>
        @endif
    </div>
</div>

@if ($students->isEmpty())
    <div class="alert alert-info">
        Belum ada data siswa. <a href="{{ route('students.create') }}">Tambah siswa sekarang</a>.
    </div>
@else
    <!-- Results Info -->
    <div class="alert alert-info mb-3">
        Menampilkan <strong>{{ $students->count() }}</strong> dari <strong>{{ $students->total() }}</strong> siswa
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key => $student)
                    <tr>
                        <td>{{ $students->firstItem() + $key }}</td>
                        <td><strong>{{ $student->nis }}</strong></td>
                        <td>{{ $student->nama }}</td>
                        <td>{{ $student->major->nama }}</td>
                        <td>{{ $student->classroom->nama }}</td>
                        <td>
                            @if ($student->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif ($student->status == 'lulus')
                                <span class="badge bg-info">Lulus</span>
                            @elseif ($student->status == 'pindah')
                                <span class="badge bg-warning">Pindah</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($students->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">« Sebelumnya</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $students->previousPageUrl() }}">« Sebelumnya</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                @if ($page == $students->currentPage())
                    <li class="page-item active">
                        <span class="page-link">
                            {{ $page }}
                            <span class="visually-hidden">(current)</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($students->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $students->nextPageUrl() }}">Selanjutnya »</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Selanjutnya »</span>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Pagination Info -->
    <div class="text-center mt-3 text-muted">
        <small>
            Halaman {{ $students->currentPage() }} dari {{ $students->lastPage() }} 
            (Total: {{ $students->total() }} siswa)
        </small>
    </div>
@endif
@endsection
