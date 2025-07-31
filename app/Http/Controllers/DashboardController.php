<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get basic statistics with eager loading
            $totalStudents = Student::count();
            $totalTeachers = Teacher::count();
            $totalSubjects = Subject::count();
            $activeClasses = Student::distinct('class_id')->count('class_id');

            // Calculate average grade
            $averageGrade = Grade::avg('score') ?? 0;

            // Get student growth
            $currentMonth = Carbon::now()->startOfMonth();
            $lastMonth = Carbon::now()->subMonth()->startOfMonth();
            $twoMonthsAgo = Carbon::now()->subMonths(2)->startOfMonth();

            $currentMonthStudents = Student::where('created_at', '>=', $currentMonth)->count();
            $lastMonthStudents = Student::whereBetween('created_at', [$lastMonth, $currentMonth])->count();
            $studentGrowth = $lastMonthStudents > 0 ?
                round((($currentMonthStudents - $lastMonthStudents) / $lastMonthStudents) * 100, 1) : 0;

            // Get performance data based on time range
            $months = $request->input('months', 6); // Default to 6 months
            $performanceData = $this->getPerformanceData($months);

            // Get class distribution data with proper relationship
            $classDistribution = Student::select('classes.name as class_name', DB::raw('count(*) as student_count'))
                ->join('classes', 'students.class_id', '=', 'classes.id')
                ->whereNotNull('class_id')
                ->groupBy('classes.name')
                ->get();

            // Get recent activities with eager loading
            $recentActivities = $this->getRecentActivities();

            // Get today's schedule with proper relationships
            $today = Carbon::now()->format('l');
            $todaySchedule = Schedule::with(['teacher', 'subject', 'class'])
                ->where('day', $today)
                ->orderBy('start_time')
                ->take(5)
                ->get()
                ->map(function ($schedule) {
                    return [
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'subject' => $schedule->subject->name,
                        'teacher' => $schedule->teacher->name,
                        'classroom' => $schedule->class->name ?? 'N/A'
                    ];
                });

            // Get attendance rate and trend
            $attendanceData = $this->getAttendanceData();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'performanceData' => $performanceData,
                    'attendanceData' => $attendanceData
                ]);
            }

            return view('dashboard', compact(
                'totalStudents',
                'totalTeachers',
                'totalSubjects',
                'activeClasses',
                'averageGrade',
                'studentGrowth',
                'performanceData',
                'classDistribution',
                'recentActivities',
                'todaySchedule',
                'attendanceData'
            ));

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return view('dashboard', [
                'error' => 'Terjadi kesalahan saat memuat dashboard',
                'totalStudents' => 0,
                'totalTeachers' => 0,
                'totalSubjects' => 0,
                'activeClasses' => 0,
                'averageGrade' => 0,
                'studentGrowth' => 0,
                'performanceData' => [],
                'classDistribution' => [],
                'recentActivities' => [],
                'todaySchedule' => [],
                'attendanceData' => ['rate' => 0, 'trend' => 0]
            ]);
        }
    }

    private function getPerformanceData($months)
    {
        $performanceData = [];
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths($months);

        for ($date = $startDate->copy(); $date <= $endDate; $date->addMonth()) {
            $monthName = $date->format('M Y');

            $avgGrade = Grade::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->avg('score') ?? 0;

            $performanceData[] = [
                'month' => $monthName,
                'grade' => round($avgGrade, 1)
            ];
        }

        return $performanceData;
    }

    private function getRecentActivities()
    {
        $recentActivities = collect();

        // Recent grades
        $recentGrades = Grade::with(['student', 'subject'])
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($grade) {
                return [
                    'type' => 'grade',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'blue',
                    'title' => 'Nilai Baru Ditambahkan',
                    'description' => "Nilai {$grade->subject->name} untuk {$grade->student->name}: {$grade->score}",
                    'time' => $grade->created_at->diffForHumans(),
                    'created_at' => $grade->created_at
                ];
            });

        // Recent students
        $recentStudents = Student::with('class')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($student) {
                return [
                    'type' => 'student',
                    'icon' => 'fas fa-user-plus',
                    'color' => 'green',
                    'title' => 'Siswa Baru Terdaftar',
                    'description' => "{$student->name} (NIS: {$student->nis}) telah mendaftar di kelas " . ($student->class->name ?? 'N/A'),
                    'time' => $student->created_at->diffForHumans(),
                    'created_at' => $student->created_at
                ];
            });

        // Recent attendance
        $recentAttendance = Attendance::with(['student', 'schedule.subject'])
            ->where('status', 'present')
            ->latest()
            ->take(1)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => 'attendance',
                    'icon' => 'fas fa-check',
                    'color' => 'purple',
                    'title' => 'Kehadiran Tercatat',
                    'description' => "{$attendance->student->name} hadir pada {$attendance->date} untuk {$attendance->schedule->subject->name}",
                    'time' => $attendance->created_at->diffForHumans(),
                    'created_at' => $attendance->created_at
                ];
            });

        return $recentGrades->concat($recentStudents)->concat($recentAttendance)
            ->sortByDesc('created_at')
            ->take(4)
            ->values();
    }

    private function getAttendanceData()
    {
        $currentPeriod = Attendance::whereDate('date', '>=', Carbon::now()->subDays(30))
            ->select('status')
            ->get();

        $totalRecords = $currentPeriod->count();
        $presentRecords = $currentPeriod->where('status', 'present')->count();

        $currentRate = $totalRecords > 0 ? round(($presentRecords / $totalRecords) * 100, 1) : 0;

        // Get previous period for trend
        $previousPeriod = Attendance::whereDate('date', '>=', Carbon::now()->subDays(60))
            ->whereDate('date', '<', Carbon::now()->subDays(30))
            ->select('status')
            ->get();

        $previousTotal = $previousPeriod->count();
        $previousPresent = $previousPeriod->where('status', 'present')->count();
        $previousRate = $previousTotal > 0 ? round(($previousPresent / $previousTotal) * 100, 1) : 0;

        $trend = round($currentRate - $previousRate, 1);

        return [
            'rate' => $currentRate,
            'trend' => $trend
        ];
    }
}
