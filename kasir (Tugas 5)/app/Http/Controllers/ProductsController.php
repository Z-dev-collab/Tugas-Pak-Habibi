<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\View\view;

class ProductsController extends Controller
{
    public function index()
    {
        $products =  Products::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'kode_barang' => 'required|string|max:255',
        'nama_barang' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
       ]);
       
       Products::create($validated);
         return redirect()->route('products.index');
    }

    public function edit($kode_barang){
        $products = Products::findOrFail($kode_barang);
        return view('products.edit', compact('products'));
    }

    public function update(Request $request, $kode_barang){
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        
        $products = Products::findOrFail($kode_barang);
        $products->update($validated);
        
        return redirect()->route('products.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy($id){
        $products = Products::findOrFail($id);
        $products->delete();
        
        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus');
    }
}
