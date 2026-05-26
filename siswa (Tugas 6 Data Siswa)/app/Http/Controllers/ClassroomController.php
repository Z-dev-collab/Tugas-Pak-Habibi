<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Major;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of all classrooms.
     */
    public function index()
    {
        $classrooms = Classroom::with('major')->get();
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new classroom.
     */
    public function create()
    {
        $majors = Major::all();
        return view('classrooms.create', compact('majors'));
    }

    /**
     * Store a newly created classroom in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'tingkat' => 'required|integer|min:1|max:6',
            'major_id' => 'required|exists:majors,id',
        ]);

        Classroom::create($validated);
        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified classroom.
     */
    public function show(Classroom $classroom)
    {
        $classroom->load(['major', 'students']);
        return view('classrooms.show', compact('classroom'));
    }

    /**
     * Show the form for editing the specified classroom.
     */
    public function edit(Classroom $classroom)
    {
        $majors = Major::all();
        return view('classrooms.edit', compact('classroom', 'majors'));
    }

    /**
     * Update the specified classroom in database.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'tingkat' => 'required|integer|min:1|max:6',
            'major_id' => 'required|exists:majors,id',
        ]);

        $classroom->update($validated);
        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified classroom from database.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil dihapus');
    }
}
