<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman tambah data Pelanggan</title>
    <link rel="stylesheet" href="css/pelanggan_create.css">
</head>
<body>
    <h1>Nama Pelanggan</h1>

    <form action="{{route('pelanggan.store')}}" method ="POST">
        @csrf
        <label for="nama_pelanggan">Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan" name="nama_pelanggan">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat">
        <button type="submit">simpan</button>
    </form>
</body>
</html>