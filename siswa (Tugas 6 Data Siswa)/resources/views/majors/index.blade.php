@extends('layouts.app')

@section('title', 'Daftar Jurusan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>📚 Daftar Jurusan</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('majors.create') }}" class="btn btn-primary">+ Tambah Jurusan</a>
    </div>
</div>

@if ($majors->isEmpty())
    <div class="alert alert-info">
        Belum ada data jurusan. <a href="{{ route('majors.create') }}">Tambah jurusan sekarang</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($majors as $key => $major)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $major->kode }}</strong></td>
                        <td>{{ $major->nama }}</td>
                        <td>
                            <a href="{{ route('majors.show', $major->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('majors.edit', $major->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('majors.destroy', $major->id) }}" method="POST" style="display:inline;">
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
