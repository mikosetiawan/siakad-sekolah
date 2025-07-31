<!-- Top Header -->
<header class="bg-white shadow-sm border-b px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Akademik</h1>
            <p class="text-gray-600">Selamat datang di sistem akademik SMK Al-Fikri Cilegon</p>
        </div>
        <div class="flex items-center space-x-4">
            {{-- <div class="relative">
                            <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div> --}}
            <div class="flex items-center space-x-3">
                @if (auth()->user()->photo)
                    <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" class="rounded-full"
                        style="width: 40px;">
                @else
                    <img src="{{ asset('assets/img/user.png') }}" alt="Profile" class="rounded-full"
                        style="width: 40px;">
                @endif

                <div>
                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Breadcrumb -->
<nav class="flex ml-6 p-2" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                    </path>
                </svg>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $title ?? '-' }}</span>
            </div>
        </li>
    </ol>
</nav>
