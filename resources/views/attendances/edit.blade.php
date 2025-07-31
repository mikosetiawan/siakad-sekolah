<x-app-layout title="Edit Kehadiran">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Kehadiran</h1>
            <p class="text-gray-600 mt-2">Ubah data kehadiran siswa</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <div class="font-bold">Terjadi kesalahan:</div>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('attendances.update', $attendance) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Schedule Selection -->
                <div class="mb-6">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Jadwal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('schedule_id') border-red-500 @enderror"
                            id="schedule_id" name="schedule_id" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->id }}"
                                    {{ old('schedule_id', $attendance->schedule_id) == $schedule->id ? 'selected' : '' }}>
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
                    @error('schedule_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Student Selection -->
                <div class="mb-6">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Siswa <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('student_id') border-red-500 @enderror"
                            id="student_id" name="student_id" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id', $attendance->student_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} - {{ $student->nim }}
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
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div class="mb-6">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('date') border-red-500 @enderror"
                        id="date" name="date" value="{{ old('date', $attendance->date) }}" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Kehadiran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="status" value="Hadir"
                                class="text-green-600 focus:ring-green-500"
                                {{ old('status', $attendance->status) == 'Hadir' ? 'checked' : '' }} required>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                Hadir
                            </span>
                        </label>

                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="status" value="Tidak Hadir"
                                class="text-red-600 focus:ring-red-500"
                                {{ old('status', $attendance->status) == 'Tidak Hadir' ? 'checked' : '' }} required>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                Tidak Hadir
                            </span>
                        </label>

                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="status" value="Terlambat"
                                class="text-yellow-600 focus:ring-yellow-500"
                                {{ old('status', $attendance->status) == 'Terlambat' ? 'checked' : '' }} required>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                Terlambat
                            </span>
                        </label>

                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="status" value="Izin"
                                class="text-lime-600 focus:ring-lime-500"
                                {{ old('status', $attendance->status) == 'Izin' ? 'checked' : '' }} required>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                <span class="inline-block w-3 h-3 bg-lime-500 rounded-full mr-2"></span>
                                Izin
                            </span>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea
                        class="w-full rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('notes') border-red-500 @enderror"
                        id="notes" name="notes" rows="4" placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $attendance->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('attendances.index') }}"
                        class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Update Kehadiran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
