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
            <div class="title">Halaman Item Transaksi</div>
        </nav>

        
        <div class="content">
        <center><a href="/transaction_items/create">Tambah</a></center>

            <table border="1">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>ID Transaksi</td>
                        <td>ID Product</td>
                        <td>Harga</td>
                        <td>QTY</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction_items as $item)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->transaction_id}}</td>
                        <td>{{$item->product_id}}</td>
                        <td>{{$item->harga}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->subtotal}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>