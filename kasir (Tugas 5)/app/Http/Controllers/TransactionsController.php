<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\View\view;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions =  Transactions::all();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'no_transaksi' => 'required|string|max:255|unique:transactions,no_transaksi',
        'tanggal' => 'required|date_format:Y-m-d\TH:i',
        'nama_kasir' => 'required|string|max:255',
        'total' => 'required|numeric',
        'uang_bayar' => 'required|numeric',
        'kembalian' => 'required|numeric',
       ]);
       
       Transactions::create($validated);
         return redirect()->route('transactions.index');
    }
}
