<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="{{asset('css/create.css')}}">
</head>
<body>
    <div class="container">
        <h1>Edit Barang</h1>
        <div class="form">
            <form action="{{ route('products.update', $products->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-item">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang" value="{{ $products->kode_barang }}" disabled>
                </div>
                <div class="form-item">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ $products->nama_barang }}">
                    @error('nama_barang')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-item">
                    <label for="harga">Harga</label>
                    <input type="text" id="harga" name="harga" value="{{ $products->harga }}">
                    @error('harga')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-item">
                    <label for="stok">Stok</label>
                    <input type="text" id="stok" name="stok" value="{{ $products->stok }}">
                    @error('stok')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="submit">
                    <button type="submit">Update</button>
                    <a href="{{ route('products.index') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>