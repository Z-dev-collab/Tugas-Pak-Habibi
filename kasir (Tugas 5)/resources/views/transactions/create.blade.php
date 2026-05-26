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
        <h1>Transaksi</h1>
        <div class="form">
            <form action="{{route('transactions.store')}}" method ="POST">
                
                <form action="{{route('transactions.store')}}" method ="POST">
                    @csrf
                    <div class="form-item">
                        <label for="no_transaksi">No Transaksi</label>
                        <input type="text" id="no_transaksi" name="no_transaksi">
                    </div>
                    <div class="form-item">
                        <label for="tanggal">Tanggal</label>
                        <input type="datetime-local" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-item">
                        <label for="nama_kasir">Nama Kasir</label>
                        <input type="text" id="nama_kasir" name="nama_kasir">
                    </div>
                    <div class="form-item">
                        <label for="total">Total</label>
                        <input type="number" id="total" name="total">
                    </div>
                    <div class="form-item">
                        <label for="uang_bayar">Uang Bayar</label>
                        <input type="number" id="uang_bayar" name="uang_bayar">
                    </div>
                    <div class="form-item">
                        <label for="kembalian">Kembalian</label>
                        <input type="number" id="kembalian" name="kembalian">
                    </div>
                    <div class="submit">
                        <button type="submit">simpan</button>
                    </div>
                </div>
        </form>
    </div>
</body>
</html>