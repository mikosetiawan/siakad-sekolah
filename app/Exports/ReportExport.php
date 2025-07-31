<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassModel;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $request;
    protected $reportData;
    protected $reportType;
    
    public function __construct($request)
    {
        $this->request = $request;
        $this->reportType = $request->report_type ?? 'attendance';
        $this->reportData = $this->getReportData();
    }
    
    protected function getReportData()
    {
        $attendanceQuery = Attendance::query();
        $gradeQuery = Grade::query();
        $studentQuery = Student::query();
        $teacherQuery = Teacher::query();
        
        if ($this->request->filled('report_type')) {
            switch ($this->reportType) {
                case 'attendance':
                    if ($this->request->filled('date_from')) {
                        $attendanceQuery->whereDate('date', '>=', $this->request->date_from);
                    }
                    if ($this->request->filled('date_to')) {
                        $attendanceQuery->whereDate('date', '<=', $this->request->date_to);
                    }
                    if ($this->request->filled('class_id')) {
                        $attendanceQuery->whereHas('student', function($q) {
                            $q->where('class_id', $this->request->class_id);
                        });
                    }
                    if ($this->request->filled('status')) {
                        $attendanceQuery->where('status', $this->request->status);
                    }
                    return $attendanceQuery->with(['student', 'student.class', 'schedule', 'schedule.subject'])->get();
                    
                case 'grades':
                    if ($this->request->filled('semester')) {
                        $gradeQuery->where('semester', $this->request->semester);
                    }
                    if ($this->request->filled('class_id')) {
                        $gradeQuery->whereHas('student', function($q) {
                            $q->where('class_id', $this->request->class_id);
                        });
                    }
                    if ($this->request->filled('subject_id')) {
                        $gradeQuery->where('subject_id', $this->request->subject_id);
                    }
                    return $gradeQuery->with(['student', 'student.class', 'subject'])->get();
                    
                case 'students':
                    if ($this->request->filled('class_id')) {
                        $studentQuery->where('class_id', $this->request->class_id);
                    }
                    return $studentQuery->with(['class'])->get();
                    
                case 'teachers':
                    if ($this->request->filled('subject_id')) {
                        $teacherQuery->whereHas('subjects', function($q) {
                            $q->where('subjects.id', $this->request->subject_id);
                        });
                    }
                    return $teacherQuery->with(['subjects'])->get();
            }
        }
        
        // Default to attendance report
        return $attendanceQuery->with(['student', 'student.class', 'schedule', 'schedule.subject'])->get();
    }
    
    public function collection()
    {
        return $this->reportData;
    }
    
    public function headings(): array
    {
        switch ($this->reportType) {
            case 'attendance':
                return [
                    'Tanggal',
                    'NIS',
                    'Nama Siswa',
                    'Kelas',
                    'Mata Pelajaran',
                    'Hari',
                    'Status',
                    'Catatan'
                ];
                
            case 'grades':
                return [
                    'NIS',
                    'Nama Siswa',
                    'Kelas',
                    'Mata Pelajaran',
                    'Nilai',
                    'Semester'
                ];
                
            case 'students':
                return [
                    'NIS',
                    'Nama',
                    'Kelas',
                    'Tanggal Lahir',
                    'Alamat'
                ];
                
            case 'teachers':
                return [
                    'NIP',
                    'Nama',
                    'Email',
                    'Telepon',
                    'Mata Pelajaran'
                ];
                
            default:
                return [];
        }
    }
    
    public function map($row): array
    {
        switch ($this->reportType) {
            case 'attendance':
                return [
                    $row->date ?? '',
                    $row->student->nis ?? '',
                    $row->student->name ?? '',
                    $row->student->class->name ?? '',
                    $row->schedule->subject->name ?? '',
                    $row->schedule->day ?? '',
                    $this->translateStatus($row->status ?? ''),
                    $row->notes ?? ''
                ];
                
            case 'grades':
                return [
                    $row->student->nis ?? '',
                    $row->student->name ?? '',
                    $row->student->class->name ?? '',
                    $row->subject->name ?? '',
                    $row->score ?? '',
                    $row->semester ?? ''
                ];
                
            case 'students':
                return [
                    $row->nis ?? '',
                    $row->name ?? '',
                    $row->class->name ?? '',
                    $row->birth_date ?? '',
                    $row->address ?? ''
                ];
                
            case 'teachers':
                return [
                    $row->nip ?? '',
                    $row->name ?? '',
                    $row->email ?? '',
                    $row->phone ?? '',
                    $row->subjects->pluck('name')->implode(', ') ?? ''
                ];
                
            default:
                return [];
        }
    }
    
    protected function translateStatus($status)
    {
        $translations = [
            'present' => 'Hadir',
            'absent' => 'Tidak Hadir',
            'sick' => 'Sakit',
            'permission' => 'Izin',
            'late' => 'Terlambat'
        ];
        
        return $translations[$status] ?? $status;
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'D9D9D9']
                ]
            ],
            
            // Set auto column widths
            'A:Z' => [
                'autoSize' => true
            ]
        ];
    }
    
    public function title(): string
    {
        $titles = [
            'attendance' => 'Laporan Kehadiran',
            'grades' => 'Laporan Nilai',
            'students' => 'Data Siswa',
            'teachers' => 'Data Guru'
        ];
        
        return $titles[$this->reportType] ?? 'Laporan';
    }
}