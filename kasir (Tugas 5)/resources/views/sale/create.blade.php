<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaksi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    {{-- <script src="script/sale.js"></script> --}}
    <div class="container">
        <div class="transaksi">
            
            <div class="data-table">
                <div class="header">
                    <h1>Transaksi Baru</h1>
                    <button type="submit">Kelola Barang</button>
            </div>
                <div class="search">
                    <input type="text" placeholder="Cari Kode / Nama Barang ">
                    <button type="submit">Cari</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Barang</td>
                            <td>Harga</td>
                            <td>Stok</td>
                            <td>Tambah</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td class="fw-semibold">{{ $p->kode_barang }}</td>
                                <td>{{ $p->nama_barang }}</td>
                                <td class="text-end">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td class="text-end">{{ $p->stok }}</td>
                                <td>
                                    <form method="POST" action="{{ route('sales.cart.add') }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $p->id }}">
                                        <input type="number" name="qty" class="form-control form-control-sm"
                                            min="1" value="1" style="width: 70px;">
                                        <button class="btn btn-sm btn-primary" type="submit"
                                            @if($p->stok == 0) disabled @endif>
                                            + Keranjang
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Barang tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="results">
                    <p>showing 1 to 8 of 10 results</p>
                    <div class="filter">
                        <button><</button>
                        <button>1</button>
                        <button>2</button>
                        <button>></button>
                    </div>
                </div>
            </div>
            <div class="keranjang">
                <h1>Keranjang</h1>

                <table>
                    <thead>
                        <tr>
                            <td>Barang</td>
                            <td>Harga</td>
                            <td>QTY</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartSummary['items'] as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item['nama_barang'] }}</div>
                                    <div class="text-muted small">{{ $item['kode_barang'] }}</div>
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('sales.cart.update') }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <input type="number" name="qty" 
                                            class="form-control form-control-sm"
                                            min="1" 
                                            value="{{ $item['qty'] }}" 
                                            style="width: 80px;">
                                        <button class="btn btn-sm btn-outline-dark" type="submit">
                                            OK
                                        </button>
                                    </form>
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </td>

                                <td class="text-end">
                                    <form method="POST" action="{{ route('sales.cart.remove') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">
                                            ×
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="data-checkout">
                    <br>
                    <br>
                    <hr>
                    <br>
                    <div class="d-flex justify-content-between">
                            <div>
                                <div class="fw-semibold">Total</div>
                            </div>
                            <div class="fw-bold">
                                Rp {{ number_format($cartSummary['total'], 0, ',', '.') }}
                            </div>
                        </div>

                        <form method="POST" action="{{ route('sales.checkout') }}" class="mt-3">
                            @csrf

                            <div class="mb-2">
                                <label class="form-label">Nama Kasir</label>
                                <input type="text" 
                                    name="nama_kasir" 
                                    value="{{ old('nama_kasir') }}"
                                    class="form-control @error('nama_kasir') is-invalid @enderror">

                                @error('nama_kasir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Uang Bayar</label>
                                <input type="number" 
                                    min="0" 
                                    name="uang_bayar" 
                                    value="{{ old('uang_bayar') }}"
                                    class="form-control @error('uang_bayar') is-invalid @enderror">

                                @error('uang_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-3">
                                <button class="btn btn-success btn-lg" type="submit">
                                    Checkout
                                </button>
                            </div>
                        </form>
                    </div>


            </div>
        </div>
    </div>
</body>
</html>