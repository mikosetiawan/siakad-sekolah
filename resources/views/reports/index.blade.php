<x-app-layout title="Reports">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Laporan Sekolah</h1>

            <!-- Filter Form -->
            <form action="{{ route('reports.index') }}" method="GET" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Report Type -->
                    <div>
                        <label for="report_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                            Laporan</label>
                        <select name="report_type" id="report_type"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="attendance" {{ request('report_type') == 'attendance' ? 'selected' : '' }}>
                                Kehadiran</option>
                            <option value="grades" {{ request('report_type') == 'grades' ? 'selected' : '' }}>Nilai
                            </option>
                            <option value="students" {{ request('report_type') == 'students' ? 'selected' : '' }}>Siswa
                            </option>
                            <option value="teachers" {{ request('report_type') == 'teachers' ? 'selected' : '' }}>Guru
                            </option>
                        </select>
                    </div>

                    <!-- Class Filter -->
                    <div id="class_filter">
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="class_id" id="class_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range (for attendance) -->
                    <div id="date_range_filter">
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div id="date_range_filter_to">
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai
                            Tanggal</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Additional filters that appear based on report type -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4" id="additional_filters">
                    <!-- Attendance Status -->
                    <div id="status_filter">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status
                            Kehadiran</label>
                        <select name="status" id="status"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester (for grades) -->
                    <div id="semester_filter">
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" id="semester"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Semester</option>
                            <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2</option>
                        </select>
                    </div>

                    <!-- Subject (for grades) -->
                    <div id="subject_filter">
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Mata
                            Pelajaran</label>
                        <select name="subject_id" id="subject_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>

                    <a href="{{ route('reports.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Reset
                    </a>

                    @if (count($reportData) > 0)
                        <div class="flex space-x-2 ml-auto">
                            <a href="{{ route('reports.export.excel', $request->all()) }}"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                                <i class="fas fa-file-excel mr-2"></i> Excel
                            </a>
                            <a href="{{ route('reports.export.pdf', $request->all()) }}"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center">
                                <i class="fas fa-file-pdf mr-2"></i> PDF
                            </a>
                        </div>
                    @endif
                </div>
            </form>

            <!-- Report Data -->
            @if (count($reportData) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @switch($reportType)
                                    @case('attendance')
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Siswa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kelas</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jadwal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Catatan</th>
                                    @break

                                    @case('grades')
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Siswa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kelas</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mata Pelajaran</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nilai</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Semester</th>
                                    @break

                                    @case('students')
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            NIS</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kelas</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Lahir</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Alamat</th>
                                    @break

                                    @case('teachers')
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telepon</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mata Pelajaran</th>
                                    @break
                                @endswitch
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reportData as $item)
                                <tr>
                                    @switch($reportType)
                                        @case('attendance')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->student->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->student->class->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $item->schedule->subject->name }} - {{ $item->schedule->day }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $item->status == 'present'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($item->status == 'absent'
                                                        ? 'bg-red-100 text-red-800'
                                                        : ($item->status == 'late'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-blue-100 text-blue-800')) }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->notes }}</td>
                                        @break

                                        @case('grades')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->student->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->student->class->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->subject->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->semester }}</td>
                                        @break

                                        @case('students')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nis }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->class->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->birth_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->address }}</td>
                                        @break

                                        @case('teachers')
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $item->subjects->pluck('name')->implode(', ') }}
                                            </td>
                                        @break
                                    @endswitch
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Tidak ada data yang ditemukan dengan filter saat ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportTypeSelect = document.getElementById('report_type');

            function toggleFilters() {
                const reportType = reportTypeSelect.value;

                // Hide all additional filters first
                document.querySelectorAll('#additional_filters > div').forEach(el => {
                    el.style.display = 'none';
                });

                // Show relevant filters based on report type
                if (reportType === 'attendance') {
                    document.getElementById('status_filter').style.display = 'block';
                    document.getElementById('date_range_filter').style.display = 'block';
                    document.getElementById('date_range_filter_to').style.display = 'block';
                    document.getElementById('class_filter').style.display = 'block';
                } else if (reportType === 'grades') {
                    document.getElementById('semester_filter').style.display = 'block';
                    document.getElementById('subject_filter').style.display = 'block';
                    document.getElementById('class_filter').style.display = 'block';
                } else if (reportType === 'students') {
                    document.getElementById('class_filter').style.display = 'block';
                } else if (reportType === 'teachers') {
                    // No additional filters for teachers report
                }
            }

            // Initial toggle
            toggleFilters();

            // Add event listener for changes
            reportTypeSelect.addEventListener('change', toggleFilters);
        });
    </script>
</x-app-layout>
