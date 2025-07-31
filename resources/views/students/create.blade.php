<x-app-layout title="Tambah Siswa">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Siswa Baru</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('name') border-red-500 @enderror"
                        id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('nis') border-red-500 @enderror"
                        id="nis" name="nis" value="{{ old('nis') }}">
                    @error('nis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('class_id') border-red-500 @enderror"
                        id="class_id" name="class_id">
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }} ({{ $class->code }})</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <div class="mt-1">
                        <div class="relative">
                            <input type="date"
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('birth_date') border-red-500 @enderror"
                                id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('address') border-red-500 @enderror"
                        id="address" name="address">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Tambah Siswa</button>
                    <a href="{{ route('students.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>