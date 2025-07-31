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

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="gradesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa</th>
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
