<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassModel; // Adjust namespace according to your Class model
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student.class', 'subject']);

        if ($request->has('class_id') && !empty($request->class_id)) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->has('subject_id') && !empty($request->subject_id)) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('semester') && !empty($request->semester)) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('min_score') && is_numeric($request->min_score)) {
            $query->where('score', '>=', $request->min_score);
        }

        if ($request->has('max_score') && is_numeric($request->max_score)) {
            $query->where('score', '<=', $request->max_score);
        }

        $grades = $query->get();
        $classes = ClassModel::all(); // Adjust according to your Class model name
        $subjects = Subject::all();

        return view('grades.index', compact('grades', 'classes', 'subjects'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:100',
            'semester' => 'required|string|max:50',
        ]);

        Grade::create($validated);
        return redirect()->route('grades.index')->with('success', 'Grade created successfully');
    }

    public function show(Grade $grade)
    {
        $grade->load(['student', 'subject']);
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('grades.edit', compact('grade', 'students', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:100',
            'semester' => 'required|string|max:50',
        ]);

        $grade->update($validated);
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully');
    }
}