<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of all majors.
     */
    public function index()
    {
        $majors = Major::all();
        return view('majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new major.
     */
    public function create()
    {
        return view('majors.create');
    }

    /**
     * Store a newly created major in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|min:2|unique:majors,kode',
            'nama' => 'required|string|min:3',
        ]);

        Major::create($validated);
        return redirect()->route('majors.index')->with('success', 'Major berhasil ditambahkan');
    }

    /**
     * Display the specified major.
     */
    public function show(Major $major)
    {
        return view('majors.show', compact('major'));
    }

    /**
     * Show the form for editing the specified major.
     */
    public function edit(Major $major)
    {
        return view('majors.edit', compact('major'));
    }

    /**
     * Update the specified major in database.
     */
    public function update(Request $request, Major $major)
    {
        $validated = $request->validate([
            'kode' => 'required|string|min:2|unique:majors,kode,' . $major->id,
            'nama' => 'required|string|min:3',
        ]);

        $major->update($validated);
        return redirect()->route('majors.index')->with('success', 'Major berhasil diperbarui');
    }

    /**
     * Remove the specified major from database.
     */
    public function destroy(Major $major)
    {
        $major->delete();
        return redirect()->route('majors.index')->with('success', 'Major berhasil dihapus');
    }
}
