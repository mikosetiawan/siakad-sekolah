<x-app-layout title="Daftar Guru">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Guru</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('teachers.create') }}"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-6">Tambah Guru Baru</a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="teachersTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->nip }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('teachers.show', $teacher) }}"
                                        class="bg-blue-600 hover:bg-blue-800 mr-2 text-white p-2 rounded-lg">Lihat</a>
                                    <a href="{{ route('teachers.edit', $teacher) }}"
                                        class="bg-yellow-600 hover:bg-yellow-800 mr-2 text-white p-2 rounded-lg">Edit</a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-800 text-white p-2 rounded-lg"
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
            $('#teachersTable').DataTable({
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