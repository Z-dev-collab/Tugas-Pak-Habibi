@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>🏫 Daftar Kelas</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary">+ Tambah Kelas</a>
    </div>
</div>

@if ($classrooms->isEmpty())
    <div class="alert alert-info">
        Belum ada data kelas. <a href="{{ route('classrooms.create') }}">Tambah kelas sekarang</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classrooms as $key => $classroom)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $classroom->nama }}</strong></td>
                        <td>
                            <span class="badge bg-primary">Tingkat {{ $classroom->tingkat }}</span>
                        </td>
                        <td>{{ $classroom->major->nama }}</td>
                        <td>
                            <a href="{{ route('classrooms.show', $classroom->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" style="display:inline;">
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
@endif
@endsection
