<x-app-layout title="Edit User">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit User: {{ $user->name }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('name') border-red-500 @enderror"
                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('email') border-red-500 @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('role') border-red-500 @enderror"
                                id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="kepala_sekolah" {{ old('role', $user->role) == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                            @if($user->photo)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Current photo" 
                                         class="h-16 w-16 rounded-full object-cover border-2 border-gray-300">
                                </div>
                            @endif
                            <input type="file"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('photo') border-red-500 @enderror"
                                id="photo" name="photo" accept="image/*">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('password') border-red-500 @enderror"
                                id="password" name="password">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none"
                                id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-4">
                            <label for="sign" class="block text-sm font-medium text-gray-700">Tanda Tangan Digital</label>
                            @if($user->sign)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Tanda tangan saat ini:</p>
                                    <img src="{{ asset('storage/' . $user->sign) }}" alt="Current signature" 
                                         class="h-12 w-24 object-contain border-2 border-gray-300 rounded bg-white p-1">
                                </div>
                            @endif
                            <input type="file"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none @error('sign') border-red-500 @enderror"
                                id="sign" name="sign" accept="image/*">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                            @error('sign')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Images -->
                        <div class="mb-4">
                            <div id="photoPreview" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preview Foto Baru:</label>
                                <img id="photoPreviewImg" class="h-24 w-24 rounded-full object-cover border-2 border-gray-300">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div id="signPreview" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preview Tanda Tangan Baru:</label>
                                <img id="signPreviewImg" class="h-16 w-32 object-contain border-2 border-gray-300 rounded bg-white p-1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 text-sm">
                        <i class="fas fa-save mr-2"></i>Update User
                    </button>
                    <a href="{{ route('users.show', $user) }}" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 text-sm">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <a href="{{ route('users.index') }}" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 text-sm">
                        <i class="fas fa-list mr-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreviewImg').src = e.target.result;
                    document.getElementById('photoPreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('photoPreview').classList.add('hidden');
            }
        });

        // Signature preview
        document.getElementById('sign').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('signPreviewImg').src = e.target.result;
                    document.getElementById('signPreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('signPreview').classList.add('hidden');
            }
        });
    </script>
</x-app-layout>