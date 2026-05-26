<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/nav.css">
</head>
<body>
    <div class="container">


    <aside>
            <div class="logo">
                <div class="profil-user">🏪</div>
                <H1>KASIR<H1>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="/products">Produk</a></li>
                    <li><a href="/transactions">Transaksi</a></li>
                    <li><a href="/transaction_items">Item Transaksi</a></li>
                </ul>
            </div>
        </aside>
    
        <nav>
            <div class="title">Halaman Transaksi</div>
        </nav>

        
        <div class="content">
        <center><a href="/transactions/create">Tambah</a></center>
            <table border="1">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>No Transaksi</td>
                        <td>Tanggal</td>
                        <td>Nama Kasir</td>
                        <td>Total</td>
                        <td>Uang Bayar</td>
                        <td>Kembalian</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$transaction->no_transaksi}}</td>
                        <td>{{$transaction->tanggal}}</td>
                        <td>{{$transaction->nama_kasir}}</td>
                        <td>{{$transaction->total}}</td>
                        <td>{{$transaction->uang_bayar}}</td>
                        <td>{{$transaction->kembalian}}</td>
                
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>