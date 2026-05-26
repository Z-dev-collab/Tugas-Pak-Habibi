<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Major;
use App\Models\Classroom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of all students.
     */
    public function index()
    {
        $query = Student::with(['major', 'classroom']);

        // Search by NIS or Name
        if ($search = request('search')) {
            $query->where('nis', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%');
        }

        // Filter by Major
        if ($major_id = request('major_id')) {
            $query->where('major_id', $major_id);
        }

        // Filter by Classroom
        if ($classroom_id = request('classroom_id')) {
            $query->where('classroom_id', $classroom_id);
        }

        // Pagination (15 items per page)
        $students = $query->paginate(15);

        // Get majors and classrooms for filter dropdowns
        $majors = Major::all();
        $classrooms = Classroom::all();

        return view('students.index', compact('students', 'majors', 'classrooms'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $majors = Major::all();
        $classrooms = Classroom::all();
        return view('students.create', compact('majors', 'classrooms'));
    }

    /**
     * Store a newly created student in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'nama' => 'required|string|min:3',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'major_id' => 'required|exists:majors,id',
            'classroom_id' => 'required|exists:classroom,id',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'status' => 'required|in:aktif,lulus,pindah,keluar',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['major', 'classroom']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $majors = Major::all();
        $classrooms = Classroom::all();
        return view('students.edit', compact('student', 'majors', 'classrooms'));
    }

    /**
     * Update the specified student in database.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'nama' => 'required|string|min:3',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'major_id' => 'required|exists:majors,id',
            'classroom_id' => 'required|exists:classroom,id',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'status' => 'required|in:aktif,lulus,pindah,keluar',
        ]);

        $student->update($validated);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified student from database.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus');
    }
}
