<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? 'Sistem Akademik Mahasiswa' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col">

        <nav class="bg-white shadow-md sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="font-bold text-xl text-blue-600">Sistem Akademik Mahasiswa</a>
                    </div>

                    <div class="md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <span class="text-gray-600 mr-4">Halo, {{ auth()->user()->name }}</span>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                   class="inline-block px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="p-8">
            {{ $slot }}
        </main>
        
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
