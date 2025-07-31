<x-app-layout title="Detail Guru">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Guru</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Nama</h2>
                <p class="text-gray-600">{{ $teacher->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">NIP</h2>
                <p class="text-gray-600">{{ $teacher->nip }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Mata Pelajaran</h2>
                <p class="text-gray-600">{{ $teacher->subject }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Telepon</h2>
                <p class="text-gray-600">{{ $teacher->phone }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Email</h2>
                <p class="text-gray-600">{{ $teacher->email }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('teachers.edit', $teacher) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                <a href="{{ route('teachers.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>