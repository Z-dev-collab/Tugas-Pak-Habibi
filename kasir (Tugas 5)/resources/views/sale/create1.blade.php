<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Baru</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="page">

    <!-- PANEL KIRI -->
    <section class="panel panel-left">
        <div class="panel-header">
            <h3>Transaksi Baru</h3>
            <button class="btn-outline">Kelola Barang</button>
        </div>

        <div class="search-grid">
            <input type="text" placeholder="Cari kode / nama barang...">
            <button class="btn-search">Cari</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tambah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>BRG003</td>
                    <td>Buku Tulis</td>
                    <td>Rp 7.000</td>
                    <td>30</td>
                    <td class="aksi">
                        <input type="number" value="1">
                        <button class="btn-cart">+ Keranjang</button>
                    </td>
                </tr>
                <tr>
                    <td>BRG009</td>
                    <td>Kertas A4 (10)</td>
                    <td>Rp 12.000</td>
                    <td>12</td>
                    <td class="aksi">
                        <input type="number" value="1">
                        <button class="btn-cart">+ Keranjang</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="table-footer">
            <span>Showing 1 to 8 of 10 results</span>
            <div class="pagination">
                <button>&lsaquo;</button>
                <button class="active">1</button>
                <button>2</button>
                <button>&rsaquo;</button>
            </div>
        </div>
    </section>

    <!-- PANEL KANAN -->
    <aside class="panel panel-right">
        <h3>Keranjang</h3>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Buku Tulis</strong><br>
                        <small>BRG003</small>
                    </td>
                    <td>Rp 7.000</td>
                    <td>
                        <input type="number" value="1">
                        <button class="btn-ok">OK</button>
                    </td>
                    <td>
                        Rp 7.000
                        <button class="btn-delete">x</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total-grid">
            <span>Total</span>
            <strong>Rp 7.000</strong>
        </div>

        <div class="form-grid">
            <label>Nama Kasir</label>
            <input type="text">

            <label>Uang Bayar</label>
            <input type="number">
        </div>

        <button class="btn-checkout">Checkout</button>
    </aside>

</div>

</body>
</html>
