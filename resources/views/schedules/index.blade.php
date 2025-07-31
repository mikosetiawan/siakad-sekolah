<x-app-layout title="Daftar Jadwal">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Jadwal</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (in_array(auth()->user()->role, ['admin']))
            <a href="{{ route('schedules.create') }}"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-6">Tambah Jadwal
                Baru</a>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="schedulesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ruang Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->teacher->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->day }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->start_time }} -
                                    {{ $schedule->end_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->classroom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @forelse ($schedule->students as $student)
                                        {{ $student->name }}{{ !$loop->last ? ', ' : '' }}
                                    @empty
                                        No students assigned
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('schedules.show', $schedule) }}"
                                        class="bg-blue-600 hover:bg-blue-800 text-white p-2 rounded-lg mr-2">Lihat</a>
                                    <a href="{{ route('schedules.edit', $schedule) }}"
                                        class="bg-yellow-600 hover:bg-yellow-800 text-white p-2 rounded-lg mr-2">Edit</a>
                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                        class="inline">
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
            $('#schedulesTable').DataTable({
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
