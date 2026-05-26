<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\view\view;

class MajorController extends Controller
{
    public function index()
    {
        $major =  Major::all();
        return view('major.index', compact('major'));
    }

    public function create()
    {
        return view('major.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'kode' => 'required|string|max:255',
        'nama' => 'required|string|max:255',
       ]);
       
       Major::create($validated);
         return redirect()->route('major.index');
    }
}
