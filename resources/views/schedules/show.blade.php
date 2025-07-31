<x-app-layout title="Detail Jadwal">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Jadwal</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Guru</h2>
                <p class="text-gray-600">{{ $schedule->teacher->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Mata Pelajaran</h2>
                <p class="text-gray-600">{{ $schedule->subject }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Hari</h2>
                <p class="text-gray-600">{{ $schedule->day }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Waktu</h2>
                <p class="text-gray-600">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Ruang Kelas</h2>
                <p class="text-gray-600">{{ $schedule->classroom }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('schedules.edit', $schedule) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                <a href="{{ route('schedules.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>