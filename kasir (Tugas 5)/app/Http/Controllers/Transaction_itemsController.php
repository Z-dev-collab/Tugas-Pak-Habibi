<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction_items;
use App\Models\Transactions;
use App\Models\Products;
use Illuminate\View\view;

class Transaction_itemsController extends Controller
{
    public function index()
    {
        $transaction_items =  Transaction_items::all();
        return view('transaction_items.index', compact('transaction_items'));
    }

    public function create()
    {
        $transactions = Transactions::all();
        $products = Products::all();
        return view('transaction_items.create', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'transaction_id' => 'required|exists:transactions,id',
        'product_id' => 'required|exists:products,id',
        'harga' => 'required|numeric',
        'qty' => 'required|numeric',
        'subtotal' => 'required|numeric',
       ]);
       
       Transaction_items::create($validated);
         return redirect()->route('transaction_items.index');
    }
}
