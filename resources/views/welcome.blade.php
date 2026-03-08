<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Primary Meta Tags -->
    <title>ParaQuarium - 水質・メンテナンスをスマートに管理できるアクアリウム専用ツール</title>
    <meta name="title" content="ParaQuarium - 水質・メンテナンスをスマートに管理できるアクアリウム専用ツール" />
    <meta name="description" content="ParaQuariumは、pH、GH、アンモニアなどの水質データや、水換え・フィルター掃除などのメンテナンスログを一元管理し、美しいアクアリウムの維持をサポートする無料ツールです。" />

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-cyan-200 cursor-default">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/50 transition-all duration-300 shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="p-1.5 bg-cyan-500 rounded-lg text-white shadow-md shadow-cyan-500/20">
                        <i data-lucide="droplets" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600 tracking-tight">ParaQuarium</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-cyan-600 transition-colors">機能の特徴</a>
                    <a href="#screens" class="text-sm font-medium text-slate-600 hover:text-cyan-600 transition-colors">画面イメージ</a>
                    <div class="h-4 w-px bg-slate-200"></div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-white bg-slate-800 hover:bg-slate-900 rounded-full transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">ダッシュボードへ</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-cyan-600 transition-colors">ログイン</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 rounded-full transition-all shadow-md shadow-cyan-500/20 hover:shadow-cyan-500/40 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">無料で始める</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-600 hover:text-cyan-600 focus:outline-none p-2">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 px-4 pt-2 pb-4 space-y-3 shadow-lg absolute w-full left-0 top-16">
            <a href="#features" class="block px-3 py-2 text-base font-medium text-slate-700 hover:text-cyan-600 hover:bg-slate-50 rounded-lg">機能の特徴</a>
            <a href="#screens" class="block px-3 py-2 text-base font-medium text-slate-700 hover:text-cyan-600 hover:bg-slate-50 rounded-lg">画面イメージ</a>
            <div class="border-t border-slate-100 my-2 pt-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-medium text-cyan-700 bg-cyan-50 rounded-lg text-center mt-2 w-full">ダッシュボードへ</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-slate-700 hover:text-cyan-600 hover:bg-slate-50 rounded-lg">ログイン</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-lg text-center mt-2 w-full">無料で始める</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 bg-slate-50">
            <div class="absolute -top-[10%] -right-[5%] w-[50%] h-[60%] rounded-full bg-gradient-to-br from-cyan-200/40 to-blue-200/40 blur-3xl opacity-70"></div>
            <div class="absolute top-[20%] -left-[10%] w-[40%] h-[50%] rounded-full bg-gradient-to-tr from-emerald-100/40 to-cyan-100/40 blur-3xl opacity-60"></div>
            <div class="absolute bottom-0 left-[20%] w-[60%] h-[40%] rounded-t-full bg-gradient-to-t from-blue-50/80 to-transparent blur-2xl"></div>
            <!-- Grid pattern overlay -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjA0LCAyMTIsIDIyNSwgMC40KSIvPjwvc3ZnPg==')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-100/50 border border-cyan-200 text-cyan-800 text-xs font-semibold tracking-wide uppercase mb-6 backdrop-blur-sm shadow-sm ring-1 ring-white">
                    <span class="flex h-2 w-2 rounded-full bg-cyan-500 animate-pulse"></span>
                    アクアリウム専用管理アプリ
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 drop-shadow-sm leading-tight group">
                    美しい水景の維持を、<br class="hidden sm:block">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 inline-block transform transition-transform duration-500 group-hover:scale-[1.02]">もっとスマートに。</span>
                </h1>
                
                <p class="mt-6 text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
                    pHやGHなどの水質測定データから、面倒な水換え・フィルター掃除の記録まで。<br class="hidden md:block">
                    <strong class="text-slate-800 font-semibold border-b-2 border-cyan-200">ParaQuarium</strong>は、あなたのアクアリウム環境を最適な状態に保つための専門ツールです。
                </p>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-900 text-white rounded-2xl font-bold transition-all shadow-xl shadow-slate-900/20 hover:shadow-slate-900/30 flex items-center justify-center gap-2 text-lg group hover:-translate-y-0.5">
                                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i> ダッシュボードへ戻る
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-cyan-500/30 hover:shadow-cyan-500/40 flex items-center justify-center gap-2 text-lg group hover:-translate-y-0.5 relative overflow-hidden">
                                    <span class="absolute inset-0 w-full h-full bg-white/20 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] skew-x-12"></span>
                                    <i data-lucide="sparkles" class="w-5 h-5 relative z-10 group-hover:rotate-12 transition-transform"></i> <span class="relative z-10">今すぐ無料で始める</span>
                                </a>
                            @endif
                            <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white/80 backdrop-blur hover:bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 text-lg hover:-translate-y-0.5">
                                <i data-lucide="arrow-down" class="w-5 h-5 text-slate-400"></i> もっと詳しく
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Real App Screenshot Display -->
            <div class="mt-20 relative max-w-5xl mx-auto" id="screens">
                <div class="rounded-2xl shadow-2xl overflow-hidden border border-slate-200/80 bg-white transform transition-all hover:shadow-[0_20px_60px_-15px_rgba(6,182,212,0.3)] hover:-translate-y-1 relative z-20 group ring-1 ring-slate-900/5">
                    <!-- Browser-like top bar to make the screenshot look good -->
                    <div class="bg-slate-100 border-b border-slate-200 px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="mx-auto w-1/2 bg-white rounded-md h-6 px-3 flex items-center justify-center shadow-sm">
                            <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1"><i data-lucide="lock" class="w-3 h-3"></i> paraquarium.app</span>
                        </div>
                    </div>
                    <!-- Real Dashboard Screenshot -->
                    <img src="{{ asset('real-dashboard.png') }}" alt="ParaQuarium 実際の画面イメージ" class="w-full h-auto object-cover group-hover:scale-[1.01] transition-transform duration-700 ease-out origin-top border-t border-slate-200/50">
                </div>
                
                <!-- Decorative elements behind mockup -->
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-cyan-400/20 rounded-full blur-2xl z-0 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl z-10 transition-transform hover:scale-110"></div>
            </div>
        </div>
        
        <!-- Curved bottom divider fade -->
        <div class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-cyan-600 font-bold tracking-wide uppercase text-sm mb-2 flex items-center justify-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i> Features</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">最適な水質管理を、すべての人に。</h3>
                <p class="text-lg text-slate-500">水槽のコンディションを数値化・記録することで、生体の健康を守りトラブルを未然に防ぐことができます。</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-lg hover:border-cyan-100 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-0 group-hover:opacity-10 transition-opacity transform translate-x-4 group-hover:translate-x-0">
                        <i data-lucide="droplet" class="w-32 h-32 text-cyan-600"></i>
                    </div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-cyan-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform group-hover:bg-cyan-50">
                        <i data-lucide="test-tubes" class="w-7 h-7 text-cyan-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-cyan-700 transition-colors">多様な水質パラメータ</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        pH、GH、アンモニア、硝酸塩など、淡水・海水問わず必要なパラメータを自由にカスタマイズして記録可能です。オリジナル項目の追加にも対応。
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-100 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-0 group-hover:opacity-10 transition-opacity transform translate-x-4 group-hover:translate-x-0">
                        <i data-lucide="calendar" class="w-32 h-32 text-blue-600"></i>
                    </div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-blue-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform group-hover:bg-blue-50">
                        <i data-lucide="clipboard-list" class="w-7 h-7 text-blue-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-blue-700 transition-colors">メンテナンスの記録</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        「前回の水換えはいつだったか？」「フィルター清掃のタイミングは？」といった悩みを解決。実施日とメモを残すことで管理が明確になります。
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-lg hover:border-indigo-100 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-0 group-hover:opacity-10 transition-opacity transform translate-x-4 group-hover:translate-x-0">
                        <i data-lucide="line-chart" class="w-32 h-32 text-indigo-600"></i>
                    </div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-indigo-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform group-hover:bg-indigo-50">
                        <i data-lucide="history" class="w-7 h-7 text-indigo-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-indigo-700 transition-colors">時系列での履歴確認</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        過去の測定データとメンテナンスの履歴を一覧で確認。数値の変化を追うことで、水槽の小さな異変にもいち早く気付くヒントになります。
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative py-20 overflow-hidden bg-slate-900 border-t-4 border-cyan-500">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="c-pattern" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M0 40L40 0H20L0 20M40 40V20L20 40" fill="none" stroke="currentColor" stroke-width="1" stroke-opacity="0.5"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#c-pattern)"></rect>
            </svg>
        </div>
        <!-- Gradient orbs -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-cyan-600/30 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-blue-600/30 rounded-full blur-[100px]"></div>

        <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">
                あなたの水槽を、最高の環境へ。
            </h2>
            <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto font-light">
                ParaQuariumは無料で始められます。面倒だったノートへのメモをデジタルに変えて、よりスマートなアクアリウムライフをはじめましょう。
            </p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-slate-900 font-bold rounded-2xl shadow-xl hover:bg-slate-50 hover:shadow-white/20 hover:-translate-y-1 transition-all text-xl">
                    アカウントを無料で作成 <i data-lucide="arrow-right" class="w-5 h-5 ml-1"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-slate-900 font-bold rounded-2xl shadow-xl hover:bg-slate-50 hover:-translate-y-1 transition-all text-xl">
                    ログインして始める <i data-lucide="arrow-right" class="w-5 h-5 ml-1"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-slate-800 rounded-lg text-white">
                    <i data-lucide="droplets" class="w-4 h-4"></i>
                </div>
                <span class="text-lg font-bold text-slate-800 tracking-tight">ParaQuarium</span>
            </div>
            <p class="text-sm text-slate-500 mb-6 font-medium">スマートな水質・メンテナンス管理ツール</p>
            
            <div class="flex space-x-6 mb-8 border-t border-slate-100 pt-8 w-full justify-center max-w-md">
                <a href="#" class="text-slate-400 hover:text-cyan-500 transition-colors">
                    <span class="sr-only">Twitter</span>
                    <i data-lucide="fish" class="w-5 h-5"></i>
                </a>
                <a href="#" class="text-slate-400 hover:text-cyan-500 transition-colors">
                    <span class="sr-only">GitHub</span>
                    <i data-lucide="github" class="w-5 h-5"></i>
                </a>
            </div>
            
            <p class="text-xs text-slate-400 font-medium">
                &copy; {{ date('Y') }} (株)GooDy. All rights reserved. Built with Laravel.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize icons
            lucide.createIcons();

            // Mobile menu toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if(mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Navbar shadow on scroll
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            });
        });
    </script>
</body>
</html>
