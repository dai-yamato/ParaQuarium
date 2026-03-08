<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParaQuarium - 水質管理システム</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-cyan-200">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 text-center max-w-2xl mx-auto">
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-cyan-500 rounded-3xl text-white shadow-xl shadow-cyan-500/30">
                    <i data-lucide="droplets" class="w-16 h-16"></i>
                </div>
            </div>
            <h1 class="text-5xl font-extrabold tracking-tight mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600 pb-2">
                ParaQuarium
            </h1>
            <p class="text-lg text-slate-500 mb-10 max-w-lg mx-auto leading-relaxed">
                アクアリウムの「水質」と「メンテナンス」を<br class="hidden sm:block">スマートに記録・管理できる専用ツールです。
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-cyan-500/30 flex items-center justify-center gap-2 text-lg">
                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> ダッシュボードへ
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 rounded-xl font-bold transition-all shadow-sm flex items-center justify-center gap-2 text-lg">
                            <i data-lucide="log-in" class="w-5 h-5"></i> ログイン
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-cyan-500/30 flex items-center justify-center gap-2 text-lg">
                                <i data-lucide="user-plus" class="w-5 h-5"></i> 無料で始める
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <div class="mt-20 text-slate-400 text-sm font-medium relative z-10 flex items-center gap-2">
            <i data-lucide="fish" class="w-4 h-4"></i> Create the perfect environment for your tank.
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
