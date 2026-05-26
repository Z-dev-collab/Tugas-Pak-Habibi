<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/major.css">
</head>
<body>
    <div class="content">
        <div class="data-siswa">
            <div class="header-table">
                <h1>Halaman Major</h1>
                <a href="/major/create" class="btn-tambah">+ Tambah</a>
                <table border="1">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Kode</td>
                            <td>Nama</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>                    
                        @foreach ($major as $majors)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$majors->kode}}</td>
                            <td>{{$majors->nama}}</td>
                            <td class='table-action'>
                                    <a class='btn-edit' href="" text-decoration:none;'>Edit</a> 
                                    <a class='btn-hapus' href= "" text-decoration:none;' onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>