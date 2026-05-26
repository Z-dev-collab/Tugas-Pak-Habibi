<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index()
    {
        $barang =  Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'varian' => 'required|string|max:255',
       ]);
       
       Barang::create($validated);
         return redirect()->route('barang.index');
    }
}
