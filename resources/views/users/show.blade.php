<x-app-layout title="Detail User">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail User</h1>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" 
                   class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 text-sm">
                    Edit User
                </a>
                <a href="{{ route('users.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Informasi User</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column - User Info -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="bg-gray-50 rounded-md px-4 py-3 text-gray-800">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="bg-gray-50 rounded-md px-4 py-3 text-gray-800">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <div class="bg-gray-50 rounded-md px-4 py-3">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'kepala_sekolah') bg-purple-100 text-purple-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bergabung Sejak</label>
                            <div class="bg-gray-50 rounded-md px-4 py-3 text-gray-800">
                                {{ $user->created_at->format('d F Y, H:i') }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir Diupdate</label>
                            <div class="bg-gray-50 rounded-md px-4 py-3 text-gray-800">
                                {{ $user->updated_at->format('d F Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Images -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                            <div class="bg-gray-50 rounded-md p-4">
                                @if($user->photo)
                                    <div class="flex flex-col items-center">
                                        <img src="{{ asset('storage/' . $user->photo) }}" 
                                             alt="Foto {{ $user->name }}" 
                                             class="h-32 w-32 rounded-full object-cover border-4 border-gray-300 mb-2">
                                        <p class="text-sm text-gray-600">{{ basename($user->photo) }}</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center py-8">
                                        <div class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center mb-2">
                                            <i class="fas fa-user text-gray-500 text-4xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">Tidak ada foto profil</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanda Tangan Digital</label>
                            <div class="bg-gray-50 rounded-md p-4">
                                @if($user->sign)
                                    <div class="flex flex-col items-center">
                                        <div class="bg-white p-4 rounded-md border-2 border-gray-300 mb-2">
                                            <img src="{{ asset('storage/' . $user->sign) }}" 
                                                 alt="Tanda tangan {{ $user->name }}" 
                                                 class="h-20 w-40 object-contain">
                                        </div>
                                        <p class="text-sm text-gray-600">{{ basename($user->sign) }}</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center py-8">
                                        <div class="h-20 w-40 bg-gray-300 flex items-center justify-center rounded-md mb-2">
                                            <i class="fas fa-signature text-gray-500 text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">Tidak ada tanda tangan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-between">
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" 
                   class="bg-yellow-600 text-white px-6 py-2 rounded-md hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i>Edit User
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            <i class="fas fa-trash mr-2"></i>Hapus User
                        </button>
                    </form>
                @endif
            </div>
            
            <a href="{{ route('users.index') }}" 
               class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>
</x-app-layout>