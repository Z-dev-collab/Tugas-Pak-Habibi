<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman tambah data post</title>
    <link rel="stylesheet" href="{{asset('css/create.css')}}">
</head>
<body>
    <div class="container">
        <h1>Nama Barang</h1>
        <div class="form">

        <form action="{{route('products.store')}}" method ="POST">
            @csrf
                <div class="form-item">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang">
                </div>

                <div class="form-item">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang">
                </div>

                <div class="form-item">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" min="1" step="1">
                </div>

                <div class="form-item">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok" min="1" step="1">
                </div>
                <div class="submit">
                    <button type="submit">simpan</button>

                </div>
            </div>
        </form>
    </div>
</body>
</html>