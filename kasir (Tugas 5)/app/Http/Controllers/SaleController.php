<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\Transaction_items;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    private function cartKey(): string
    {
        return 'cart_items';
    }

    private function computeCart(array $cart): array
    {
        $items = [];
        $total = 0;

        foreach ($cart as $row) {
            $subtotal = (int) $row['harga'] * (int) $row['qty'];
            $items[] = [
                ...$row,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }

        return [
            'items' => $items,
            'total' => $total,
        ];
    }

    private function generateNoTransaksi(): string
    {
        $date   = now()->format('Ymd');
        $prefix = "TRX-{$date}-";

        $last = Transactions::where('no_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = $last
            ? ((int) substr($last->no_transaksi, strlen($prefix)) + 1)
            : 1;

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function create(Request $request)
    {
        $q = $request->query('q');

        $products = Products::query()
            ->when($q, function ($query) use ($q) {
                $query->where('kode_barang', 'like', "%{$q}%")
                      ->orWhere('nama_barang', 'like', "%{$q}%");
            })
            ->orderBy('kode_barang')
            ->paginate(10)
            ->withQueryString();

        $cart = session()->get($this->cartKey(), []);
        $cartSummary = $this->computeCart($cart);

        return view('sale.create', compact('products', 'q', 'cartSummary'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Products::findOrFail($data['product_id']);

        $cart = session()->get($this->cartKey(), []);
        $currentQty = $cart[$product->id]['qty'] ?? 0;
        $newQty = $currentQty + (int) $data['qty'];

        if ($newQty > $product->stok) {
            return back()->with('error', "Stok tidak cukup. Tersisa: {$product->stok}");
        }

        $cart[$product->id] = [
            'product_id'  => $product->id,
            'kode_barang' => $product->kode_barang,
            'nama_barang' => $product->nama_barang,
            'harga'       => (int) $product->harga,
            'qty'         => $newQty,
        ];

        session([$this->cartKey() => $cart]);
        return back()->with('success', 'Item ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'qty'        => 'required|integer|min:1',
        ]);

        $cart = session()->get($this->cartKey(), []);

        if (!isset($cart[$data['product_id']])) {
            return back();
        }

        $product = Products::findOrFail($data['product_id']);

        if ($data['qty'] > $product->stok) {
            return back()->with('error', "Stok tidak cukup. Tersisa: {$product->stok}");
        }

        $cart[$data['product_id']]['qty'] = (int) $data['qty'];
        session([$this->cartKey() => $cart]);

        return back()->with('success', 'QTY diperbarui.');
    }

    public function removeFromCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
        ]);

        $cart = session()->get($this->cartKey(), []);
        unset($cart[$data['product_id']]);

        session([$this->cartKey() => $cart]);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
    
    public function checkout(CheckoutRequest $request)
    {
        $cart = session()->get($this->cartKey(), []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $cartSummary = $this->computeCart($cart);
        $uangBayar   = (int) $request->uang_bayar;

        if ($uangBayar < $cartSummary['total']) {
            return back()->with('error', 'Uang bayar kurang.');
        }

        $transaction = DB::transaction(function () use ($cart, $cartSummary, $request, $uangBayar) {
            $trx = Transactions::create([
                'no_transaksi' => $this->generateNoTransaksi(),
                'tanggal'      => now(),
                'nama_kasir'   => $request->nama_kasir,
                'total'        => $cartSummary['total'],
                'uang_bayar'   => $uangBayar,
                'uang_kembali' => $uangBayar - $cartSummary['total'],
            ]);

            $products = Products::whereIn('id', array_keys($cart))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($cart as $row) {
                $product = $products[$row['product_id']];

                if ($row['qty'] > $product->stok) {
                    throw new \Exception("Stok {$product->nama_barang} tidak cukup.");
                }

                Transaction_items::create([
                    'transaction_id' => $trx->id,
                    'product_id'     => $product->id,
                    'harga'          => $row['harga'],
                    'qty'            => $row['qty'],
                    'subtotal'       => $row['harga'] * $row['qty']
                ]);

                $product->stok -= $row['qty'];
                $product->save();
            }

            return $trx;
        });

        session()->forget($this->cartKey());
        return redirect()->route('receipt', $transaction)
            ->with('success', 'Transaksi berhasil.');
    }

    public function receipt(Transactions $transaction)
    {
        $transaction->load('items.product');
        return view('sale.receipt', compact('transaction'));
    }
}
