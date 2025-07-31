<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Models\Subject;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query builders
        $attendanceQuery = Attendance::query();
        $gradeQuery = Grade::query();
        $studentQuery = Student::query();
        $teacherQuery = Teacher::query();

        // Apply filters if they exist
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'attendance':
                    if ($request->filled('date_from')) {
                        $attendanceQuery->whereDate('date', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $attendanceQuery->whereDate('date', '<=', $request->date_to);
                    }
                    if ($request->filled('class_id')) {
                        $attendanceQuery->whereHas('student', function ($q) use ($request) {
                            $q->where('class_id', $request->class_id);
                        });
                    }
                    if ($request->filled('status')) {
                        $attendanceQuery->where('status', $request->status);
                    }
                    break;

                case 'grades':
                    if ($request->filled('semester')) {
                        $gradeQuery->where('semester', $request->semester);
                    }
                    if ($request->filled('class_id')) {
                        $gradeQuery->whereHas('student', function ($q) use ($request) {
                            $q->where('class_id', $request->class_id);
                        });
                    }
                    if ($request->filled('subject_id')) {
                        $gradeQuery->where('subject_id', $request->subject_id);
                    }
                    break;

                case 'students':
                    if ($request->filled('class_id')) {
                        $studentQuery->where('class_id', $request->class_id);
                    }
                    break;
            }
        }

        // Get data based on report type
        $reportData = [];
        $reportType = $request->report_type ?? 'attendance';

        switch ($reportType) {
            case 'attendance':
                $reportData = $attendanceQuery->with(['student', 'schedule'])->get();
                break;

            case 'grades':
                $reportData = $gradeQuery->with(['student', 'subject'])->get();
                break;

            case 'students':
                $reportData = $studentQuery->with(['class'])->get();
                break;

            case 'teachers':
                $reportData = $teacherQuery->get();
                break;
        }

        // Get filter data
        $classes = ClassModel::all();
        $subjects = Subject::all();
        $statuses = ['present', 'absent', 'sick', 'permission', 'late'];

        return view('reports.index', compact(
            'reportData',
            'reportType',
            'classes',
            'subjects',
            'statuses',
            'request'
        ));
    }

    public function exportExcel(Request $request)
    {
        // Validate report type
        $validTypes = ['attendance', 'grades', 'students', 'teachers'];
        $reportType = in_array($request->report_type, $validTypes) ? $request->report_type : 'attendance';

        // Generate filename with timestamp
        $fileName = 'laporan_' . $this->translateReportType($reportType) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ReportExport($request), $fileName);
    }

    protected function translateReportType($type)
    {
        $translations = [
            'attendance' => 'kehadiran',
            'grades' => 'nilai',
            'students' => 'siswa',
            'teachers' => 'guru'
        ];

        return $translations[$type] ?? $type;
    }

    public function exportPdf(Request $request)
    {
        // Replicate the data fetching logic from index but don't return a view
        $attendanceQuery = Attendance::query();
        $gradeQuery = Grade::query();
        $studentQuery = Student::query();
        $teacherQuery = Teacher::query();

        $reportType = $request->report_type ?? 'attendance';

        // Apply filters if they exist
        if ($request->filled('report_type')) {
            switch ($request->report_type) {
                case 'attendance':
                    if ($request->filled('date_from')) {
                        $attendanceQuery->whereDate('date', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $attendanceQuery->whereDate('date', '<=', $request->date_to);
                    }
                    if ($request->filled('class_id')) {
                        $attendanceQuery->whereHas('student', function ($q) use ($request) {
                            $q->where('class_id', $request->class_id);
                        });
                    }
                    if ($request->filled('status')) {
                        $attendanceQuery->where('status', $request->status);
                    }
                    $reportData = $attendanceQuery->with(['student', 'schedule'])->get();
                    break;

                case 'grades':
                    if ($request->filled('semester')) {
                        $gradeQuery->where('semester', $request->semester);
                    }
                    if ($request->filled('class_id')) {
                        $gradeQuery->whereHas('student', function ($q) use ($request) {
                            $q->where('class_id', $request->class_id);
                        });
                    }
                    if ($request->filled('subject_id')) {
                        $gradeQuery->where('subject_id', $request->subject_id);
                    }
                    $reportData = $gradeQuery->with(['student', 'subject'])->get();
                    break;

                case 'students':
                    if ($request->filled('class_id')) {
                        $studentQuery->where('class_id', $request->class_id);
                    }
                    $reportData = $studentQuery->with(['class'])->get();
                    break;

                case 'teachers':
                    $reportData = $teacherQuery->get();
                    break;
            }
        } else {
            // Default to attendance report if no type specified
            $reportData = $attendanceQuery->with(['student', 'schedule'])->get();
        }

        // Get additional data needed for the PDF
        $classes = ClassModel::all();
        $subjects = Subject::all();

        // Load the PDF view with the data
        $pdf = PDF::loadView('reports.pdf', [
            'reportData' => $reportData,
            'reportType' => $reportType,
            'filters' => $request->all(),
            'classes' => $classes,
            'subjects' => $subjects
        ]);

        $fileName = 'report_' . $reportType . '_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
}