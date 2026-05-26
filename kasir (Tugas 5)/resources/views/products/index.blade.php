<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/nav.css">
    <title>Master Barang</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Master Barang</h1>
            <a href="/products/create">+ Tambah Barang</a>
        </div>
    
        <div class="data-table">
            <div class="search">
                <input type="text" placeholder="Cari Kode / Nama Barang..">
                <button type="submit">Cari</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Barang</td>
                        <td>Harga</td>
                        <td>Stok</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$product->nama_barang}}</td>
                        <td>{{$product->harga}}</td>
                        <td>{{$product->stok}}</td>
                        <td>
                            <div class="aksi">
                                <a class='btn-edit' href='{{ route('products.edit', $product->id)}}' style='text-decoration:none;'>Edit</a> 
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type='submit' class='btn-hapus' onclick="return confirm('Yakin ingin menghapus data ini?');" style="border:none; cursor:pointer;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>