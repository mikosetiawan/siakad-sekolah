<x-app-layout title="Tambah Kehadiran Berdasarkan Jadwal">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Kehadiran Berdasarkan Jadwal</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf

                <!-- Schedule Selection -->
                <div class="mb-4 relative">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Jadwal</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('schedule_id') border-red-500 @enderror"
                                id="schedule_id" name="schedule_id" onchange="loadStudents()">
                                <option value="">Pilih Jadwal</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}"
                                            {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->subject->name }} - {{ $schedule->teacher->name }}
                                        ({{ $schedule->day }} {{ $schedule->start_time }}-{{ $schedule->end_time }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('schedule_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Selection -->
                <div class="mb-4 relative">
                    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <div class="mt-1">
                        <div class="relative">
                            <input type="date"
                                   class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('date') border-red-500 @enderror"
                                   id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}">
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                          clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Students Attendance Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Siswa</label>
                    <div id="students-container" class="mt-2 space-y-4">
                        <!-- Students will be dynamically loaded here -->
                    </div>
                    @error('attendances')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex space-x-4">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                        Simpan Kehadiran
                    </button>
                    <a href="{{ route('attendances.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        async function loadStudents() {
            const scheduleId = document.getElementById('schedule_id').value;
            const container = document.getElementById('students-container');
            container.innerHTML = '';

            if (scheduleId) {
                try {
                    const response = await fetch(`/schedules/${scheduleId}/students`);
                    if (!response.ok) {
                        throw new Error('Failed to fetch students');
                    }
                    const students = await response.json();

                    if (students.length === 0) {
                        container.innerHTML = '<p class="text-sm text-gray-500">Tidak ada siswa terdaftar untuk jadwal ini.</p>';
                        return;
                    }

                    students.forEach(student => {
                        const studentDiv = document.createElement('div');
                        studentDiv.className = 'border p-4 rounded-md';
                        studentDiv.innerHTML = `
                            <input type="hidden" name="attendances[${student.id}][student_id]" value="${student.id}">
                            <div class="mb-2">
                                <label class="block text-sm font-medium text-gray-700">${student.name}</label>
                            </div>
                            <div class="mb-2">
                                <select
                                    class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none"
                                    name="attendances[${student.id}][status]">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                    <option value="Terlambat">Terlambat</option>
                                    <option value="Izin">Izin</option>
                                </select>
                            </div>
                            <div>
                                <textarea
                                    class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none"
                                    name="attendances[${student.id}][notes]" placeholder="Catatan (opsional)"></textarea>
                            </div>
                        `;
                        container.appendChild(studentDiv);
                    });
                } catch (error) {
                    console.error('Error loading students:', error);
                    container.innerHTML = '<p class="text-sm text-red-600">Gagal memuat data siswa. Silakan coba lagi.</p>';
                }
            } else {
                container.innerHTML = '<p class="text-sm text-gray-500">Pilih jadwal untuk melihat daftar siswa.</p>';
            }
        }

        // Initialize students container on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadStudents();
        });
    </script>
</x-app-layout>