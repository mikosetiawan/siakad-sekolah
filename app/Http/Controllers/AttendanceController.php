<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['student', 'schedule'])->get();
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $schedules = Schedule::with('students', 'subject', 'teacher')->get();
        return view('attendances.create', compact('schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:Hadir,Tidak Hadir,Terlambat,Izin',
            'attendances.*.notes' => 'nullable|string',
        ]);

        foreach ($request->attendances as $attendanceData) {
            Attendance::create([
                'schedule_id' => $validated['schedule_id'],
                'student_id' => $attendanceData['student_id'],
                'date' => $validated['date'],
                'status' => $attendanceData['status'],
                'notes' => $attendanceData['notes'],
            ]);
        }

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully');
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('student', 'schedule');
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::all();
        $schedules = Schedule::all();
        return view('attendances.edit', compact('attendance', 'students', 'schedules'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:Hadir,Tidak Hadir,Terlambat,Izin',
            'notes' => 'nullable|string',
        ]);

        $attendance->update($validated);
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}