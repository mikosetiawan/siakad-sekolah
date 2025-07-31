<x-app-layout title="Kelola Mata Pelajaran">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Mata Pelajaran</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('subjects.create') }}"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-6">Tambah Mata
            Pelajaran</a>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="overflow-x-auto">
                <table id="subjectsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($subjects as $subject)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $subject->code }}</td>
                                <td class="px-6 py-4">{{ $subject->description ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('subjects.show', $subject) }}"
                                        class="bg-blue-600 hover:bg-blue-800 p-2 rounded-lg text-white">Lihat</a>
                                    <a href="{{ route('subjects.edit', $subject) }}"
                                        class="bg-yellow-600 hover:bg-yellow-800 p-2 rounded-lg text-white ml-4">Edit</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-800 p-2 rounded-lg text-white ml-4">Hapus</button>
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
            $('#subjectsTable').DataTable({
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
