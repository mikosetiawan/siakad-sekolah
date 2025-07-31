<x-app-layout title="Detail Mata Pelajaran">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Mata Pelajaran</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Nama Mata Pelajaran</h2>
                <p class="text-gray-900">{{ $subject->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Kode Mata Pelajaran</h2>
                <p class="text-gray-900">{{ $subject->code }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Deskripsi</h2>
                <p class="text-gray-900">{{ $subject->description ?? '-' }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('subjects.edit', $subject) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 text-sm">Edit</a>
                <a href="{{ route('subjects.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>