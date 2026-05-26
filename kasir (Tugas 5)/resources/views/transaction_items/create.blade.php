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
        <h1>Item Transaksi</h1>
        <div class="form">
            <form action="{{route('transaction_items.store')}}" method ="POST">
                @csrf
                <div class="form-item">
                    <label for="transaction_id">ID Transaksi</label>
                    <select name="transaction_id" id="transaction_id">
                        @foreach ($transactions as $transaction)
                        <option value="{{$transaction->id}}">
                    {{$transaction->no_transaksi}}
                </option>
                @endforeach
            </select>
            </div>

            <div class="form-item">
                <label for="product_id">ID Produk</label>
                <select name="product_id" id="product_id">
                    @foreach ($products as $product)
                    <option value="{{$product->id}}">
                {{$product->nama_barang}}
            </option>
            @endforeach
        </select>
        </div>

        <div class="form-item">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga">
        </div>

        <div class="form-item">
            <label for="qty">QTY</label>
            <input type="number" id="qty" name="qty">
        </div>

        <div class="form-item">
            <label for="subtotal">Subtotal</label>
            <input type="number" id="subtotal" name="subtotal">
        </div>
        
        <div class="submit">
        <button type="submit">simpan</button>   
        </div>
    </form>
</div>
</div>
</body>
</html>