<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('teacher', 'subject', 'students', 'class')->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        return view('schedules.create', compact('teachers', 'subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $schedule = Schedule::create($validated);
        if ($request->has('students')) {
            $schedule->students()->sync($request->input('students'));
        }

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('teacher', 'students', 'subject', 'class');
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        return view('schedules.edit', compact('schedule', 'teachers', 'subjects', 'classes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $schedule->update($validated);
        $schedule->students()->sync($request->input('students', []));

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->students()->detach();
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }

    public function getStudents(Schedule $schedule)
    {
        return response()->json($schedule->students);
    }
}