<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan =  Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
       ]);
       
       Pelanggan::create($validated);
         return redirect()->route('pelanggan.index');
    }
}
