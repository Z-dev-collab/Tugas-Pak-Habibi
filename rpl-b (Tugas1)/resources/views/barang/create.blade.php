<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman tambah data post</title>
</head>
<body>
    <h1>Nama Barang</h1>

    <form action="{{route('barang.store')}}" method ="POST">
        @csrf
        <label for="nama_barang">Nama Barang</label>
        <input type="text" id="nama_barang" name="nama_barang">

        <label for="varian">Varian</label>
        <input type="text" id="varian" name="varian">
        <button type="submit">simpan</button>
    </form>
</body>
</html>