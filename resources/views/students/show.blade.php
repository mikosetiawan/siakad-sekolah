<x-app-layout title="Detail Siswa">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Siswa</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Nama</h2>
                <p class="text-gray-600">{{ $student->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">NIS</h2>
                <p class="text-gray-600">{{ $student->nis }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Kelas</h2>
                <p class="text-gray-600">{{ $student->class->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Tanggal Lahir</h2>
                <p class="text-gray-600">{{ $student->birth_date }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-700">Alamat</h2>
                <p class="text-gray-600">{{ $student->address }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('students.edit', $student) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                <a href="{{ route('students.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>