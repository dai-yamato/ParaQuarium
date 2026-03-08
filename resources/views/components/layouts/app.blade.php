<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParaQuarium - 水質管理システム</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- React & Lucide for icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <!-- Alpine JS is loaded by Livewire -->
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-cyan-200">
    <div class="min-h-screen">
        <!-- Navigation / Header -->
        <header class="bg-white border-b shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-cyan-500 rounded-lg text-white">
                        <i data-lucide="droplets" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600">ParaQuarium</span>
                </div>
                
                @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-800 focus:outline-none transition-colors">
                        {{ Auth::user()->name }}
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div x-show="open" x-cloak x-transition.opacity
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4"></i> プロフィール
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 flex items-center gap-2">
                                <i data-lucide="log-out" class="w-4 h-4"></i> ログアウト
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:load', () => {
            lucide.createIcons();
        });
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
