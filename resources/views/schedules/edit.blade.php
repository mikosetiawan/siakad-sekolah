<x-app-layout title="Edit Jadwal">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Jadwal</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4 relative">
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Guru</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('teacher_id') border-red-500 @enderror"
                                id="teacher_id" name="teacher_id">
                                <option value="">Pilih Guru</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
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
                    @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('subject_id') border-red-500 @enderror"
                                id="subject_id" name="subject_id">
                                <option value="">Pilih Mata Pelajaran Supplemental

                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}
                                        ({{ $subject->code }})</option>
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
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('class_id') border-red-500 @enderror"
                                id="class_id" name="class_id">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                        ({{ $class->code }})</option>
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
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label for="day" class="block text-sm font-medium text-gray-700">Hari</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('day') border-red-500 @enderror"
                                id="day" name="day">
                                <option value="Senin" {{ old('day', $schedule->day) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ old('day', $schedule->day) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ old('day', $schedule->day) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ old('day', $schedule->day) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ old('day', $schedule->day) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ old('day', $schedule->day) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
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
                    @error('day')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <div class="relative">
                        <input type="time"
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('start_time') border-red-500 @enderror"
                            id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}">
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <div class="relative">
                        <input type="time"
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('end_time') border-red-500 @enderror"
                            id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}">
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label for="students" class="block text-sm font-medium text-gray-700">Siswa</label>
                    <div class="mt-1">
                        <div class="relative">
                            <button type="button" id="students-toggle"
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-left shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('students') border-red-500 @enderror">
                                <span id="students-selected" class="block truncate text-sm text-gray-700">Pilih siswa</span>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                            <div id="students-dropdown"
                                class="absolute z-10 mt-1 hidden w-full rounded-md bg-white shadow-lg max-h-60 overflow-auto">
                                <!-- Students will be populated dynamically -->
                            </div>
                        </div>
                    </div>
                    @error('students')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Perbarui Jadwal</button>
                    <a href="{{ route('schedules.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateSelectedStudents() {
            const checkboxes = document.querySelectorAll('input[name="students[]"]:checked');
            const selectedSpan = document.getElementById('students-selected');
            const selectedNames = Array.from(checkboxes).map(cb => cb.parentElement.querySelector('span').textContent);

            if (selectedNames.length === 0) {
                selectedSpan.textContent = 'Pilih siswa';
            } else {
                selectedSpan.textContent = selectedNames.join(', ');
            }
        }

        document.getElementById('students-toggle').addEventListener('click', () => {
            const dropdown = document.getElementById('students-dropdown');
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            const toggle = document.getElementById('students-toggle');
            const dropdown = document.getElementById('students-dropdown');
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.getElementById('class_id').addEventListener('change', function() {
            const classId = this.value;
            const studentsDropdown = document.getElementById('students-dropdown');
            studentsDropdown.innerHTML = ''; // Clear existing students

            if (classId) {
                fetch(`/classes/${classId}/students`)
                    .then(response => response.json())
                    .then(students => {
                        students.forEach(student => {
                            const label = document.createElement('label');
                            label.className = 'flex items-center px-4 py-2 hover:bg-gray-100';
                            const isChecked = {{ json_encode(old('students', $schedule->students->pluck('id')->toArray())) }}.includes(student.id) ? 'checked' : '';
                            label.innerHTML = `
                                <input type="checkbox" name="students[]" value="${student.id}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    ${isChecked}
                                    onchange="updateSelectedStudents()">
                                <span class="ml-2 text-sm text-gray-700">${student.name}</span>
                            `;
                            studentsDropdown.appendChild(label);
                        });
                        updateSelectedStudents();
                    })
                    .catch(error => console.error('Error fetching students:', error));
            }
        });

        // Initialize students for the selected class
        const initialClassId = document.getElementById('class_id').value;
        if (initialClassId) {
            fetch(`/classes/${initialClassId}/students`)
                .then(response => response.json())
                .then(students => {
                    const studentsDropdown = document.getElementById('students-dropdown');
                    students.forEach(student => {
                        const label = document.createElement('label');
                        label.className = 'flex items-center px-4 py-2 hover:bg-gray-100';
                        const isChecked = {{ json_encode(old('students', $schedule->students->pluck('id')->toArray())) }}.includes(student.id) ? 'checked' : '';
                        label.innerHTML = `
                            <input type="checkbox" name="students[]" value="${student.id}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                ${isChecked}
                                onchange="updateSelectedStudents()">
                            <span class="ml-2 text-sm text-gray-700">${student.name}</span>
                        `;
                        studentsDropdown.appendChild(label);
                    });
                    updateSelectedStudents();
                })
                .catch(error => console.error('Error fetching students:', error));
        }
    </script>
</x-app-layout>