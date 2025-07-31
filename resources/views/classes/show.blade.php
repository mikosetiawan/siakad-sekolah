<x-app-layout title="Detail Kelas">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Kelas</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Kode Kelas</h2>
                    <p class="mt-1 text-gray-600">{{ $class->code }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Nama Kelas</h2>
                    <p class="mt-1 text-gray-600">{{ $class->name }}</p>
                </div>
                <div class="md:col-span-2">
                    <h2 class="text-lg font-semibold text-gray-700">Deskripsi</h2>
                    <p class="mt-1 text-gray-600">{{ $class->description ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('classes.edit', $class) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 text-sm">Edit Kelas</a>
                <a href="{{ route('classes.index') }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
