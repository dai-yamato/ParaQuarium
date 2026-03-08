<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ParaQuarium - ログイン</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- React & Lucide for icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-cyan-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/" class="flex flex-col items-center gap-3">
                <div class="p-3 bg-cyan-500 rounded-2xl text-white shadow-lg shadow-cyan-500/30">
                    <i data-lucide="droplets" class="w-10 h-10"></i>
                </div>
                <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600 tracking-tight">ParaQuarium</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-3xl border border-slate-100 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500"></div>
            {{ $slot }}
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
