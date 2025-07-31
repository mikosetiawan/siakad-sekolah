<x-app-layout title="Tambah Nilai">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Nilai Baru</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf
                <div class="mb-4 relative">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Siswa</label>
                    <div class="mt-1">
                        <div class="relative">
                            <select
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 appearance-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('student_id') border-red-500 @enderror"
                                id="student_id" name="student_id">
                                <option value="">Pilih Siswa</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
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
                    @error('student_id')
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
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }} ({{ $subject->code }})</option>
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

                <div class="mb-4">
                    <label for="score" class="block text-sm font-medium text-gray-700">Nilai</label>
                    <input type="number"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('score') border-red-500 @enderror"
                        id="score" name="score" value="{{ old('score') }}" min="0" max="100">
                    @error('score')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('semester') border-red-500 @enderror"
                        id="semester" name="semester" value="{{ old('semester') }}">
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Tambah Nilai</button>
                    <a href="{{ route('grades.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>