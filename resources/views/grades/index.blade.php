<x-app-layout title="Daftar Nilai">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Nilai</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (in_array(auth()->user()->role, ['guru', 'wali_kelas','admin']))
            <a href="{{ route('grades.create') }}"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-6">Tambah Nilai
                Baru</a>
        @endif

        <div class="bg-white shadow-md rounded-lg p-5 mb-6">
            <form method="GET" action="{{ route('grades.index') }}" class="flex flex-wrap gap-4 mb-6">
                <div class="flex-1 min-w-[200px]">
                    <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select name="class_id" id="class_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="flex-1 min-w-[200px]">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester" id="semester"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Semua Semester</option>
                        <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2</option>
                    </select>
                </div> --}}
                <div class="flex-1 min-w-[200px]">
                    <label for="min_score" class="block text-sm font-medium text-gray-700">Nilai Minimum</label>
                    <input type="number" name="min_score" id="min_score" value="{{ request('min_score') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                           placeholder="0-100" min="0" max="100">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="max_score" class="block text-sm font-medium text-gray-700">Nilai Maksimum</label>
                    <input type="number" name="max_score" id="max_score" value="{{ request('max_score') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                           placeholder="0-100" min="0" max="100">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Filter</button>
                    <a href="{{ route('grades.index') }}"
                       class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">Reset</a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="gradesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Semester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($grades as $grade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $grade->student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $grade->student->class->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $grade->subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $grade->score }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $grade->semester }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('grades.show', $grade) }}"
                                        class="bg-blue-600 hover:bg-blue-800 mr-2 text-white p-2 rounded-lg">Lihat</a>
                                    <a href="{{ route('grades.edit', $grade) }}"
                                        class="bg-yellow-600 hover:bg-yellow-800 mr-2 text-white p-2 rounded-lg">Edit</a>
                                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-800 text-white p-2 rounded-lg"
                                            onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#gradesTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "Filter data:",
                    lengthMenu: "Tampilkan _MENU_ entri"
                }
            });
        });
    </script>
</x-app-layout>