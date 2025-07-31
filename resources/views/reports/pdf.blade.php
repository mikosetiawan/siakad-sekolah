<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Sekolah</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .header p { font-size: 14px; margin: 5px 0 0; }
        .logo { width: 80px; height: auto; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        .filter-info { margin-bottom: 20px; font-size: 14px; }
        .filter-info p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/img/alminhaj.png') }}" class="logo" alt="Logo Sekolah">
        <h1>SMK AL-FIKRI CILEGON</h1>
        <p>Jl. CIlegon raya No. 123, Cilegon</p>
        <p>Laporan {{ ucfirst($reportType) }}</p>
    </div>
    
    <div class="filter-info">
        <p><strong>Filter yang digunakan:</strong></p>
        @if(isset($filters['date_from']) || isset($filters['date_to']))
            <p>Tanggal: 
                {{ isset($filters['date_from']) ? $filters['date_from'] : 'Awal' }} 
                s/d 
                {{ isset($filters['date_to']) ? $filters['date_to'] : 'Akhir' }}
            </p>
        @endif
        @if(isset($filters['class_id']) && $class = \App\Models\ClassModel::find($filters['class_id']))
            <p>Kelas: {{ $class->name }}</p>
        @endif
        @if(isset($filters['status']))
            <p>Status: {{ ucfirst($filters['status']) }}</p>
        @endif
        @if(isset($filters['semester']))
            <p>Semester: {{ $filters['semester'] }}</p>
        @endif
        @if(isset($filters['subject_id']) && $subject = \App\Models\Subject::find($filters['subject_id']))
            <p>Mata Pelajaran: {{ $subject->name }}</p>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                @switch($reportType)
                    @case('attendance')
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        @break
                        
                    @case('grades')
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Semester</th>
                        @break
                        
                    @case('students')
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        @break
                        
                    @case('teachers')
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Mata Pelajaran</th>
                        @break
                @endswitch
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $item)
                <tr>
                    @switch($reportType)
                        @case('attendance')
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->student->name }}</td>
                            <td>{{ $item->student->class->name }}</td>
                            <td>{{ $item->schedule->subject->name }} - {{ $item->schedule->day }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->notes }}</td>
                            @break
                            
                        @case('grades')
                            <td>{{ $item->student->name }}</td>
                            <td>{{ $item->student->class->name }}</td>
                            <td>{{ $item->subject->name }}</td>
                            <td>{{ $item->score }}</td>
                            <td>{{ $item->semester }}</td>
                            @break
                            
                        @case('students')
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->class->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->address }}</td>
                            @break
                            
                        @case('teachers')
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->subjects->pluck('name')->implode(', ') }}</td>
                            @break
                    @endswitch
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Oleh: {{ auth()->user()->name }}</p>
    </div>
</body>
</html>