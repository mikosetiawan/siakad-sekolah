<x-app-layout title="Detail Nilai">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Nilai</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Siswa</h2>
                <p class="text-gray-600">{{ $grade->student->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Mata Pelajaran</h2>
                <p class="text-gray-600">{{ $grade->subject->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Nilai</h2>
                <p class="text-gray-600">{{ $grade->score }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Semester</h2>
                <p class="text-gray-600">{{ $grade->semester }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('grades.edit', $grade) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                <a href="{{ route('grades.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>