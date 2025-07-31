<x-app-layout title="Detail Kehadiran">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Kehadiran</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Siswa</h2>
                <p class="text-gray-600">{{ $attendance->student->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Tanggal</h2>
                <p class="text-gray-600">{{ $attendance->date }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Status</h2>
                <p class="text-gray-600">{{ $attendance->status }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Catatan</h2>
                <p class="text-gray-600">{{ $attendance->notes }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('attendances.edit', $attendance) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                <a href="{{ route('attendances.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>