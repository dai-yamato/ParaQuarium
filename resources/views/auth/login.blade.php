<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="パスワード" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-cyan-600 shadow-sm focus:ring-cyan-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">ログイン状態を保持する</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate-500 hover:text-slate-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500" href="{{ route('password.request') }}">
                    パスワードをお忘れですか？
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto">
                <i data-lucide="log-in" class="w-4 h-4 mr-2"></i> ログイン
            </x-primary-button>
            <a href="{{ route('register') }}" class="text-sm text-cyan-600 hover:text-cyan-800 underline block text-center sm:hidden mt-2">アカウントを作成</a>
        </div>
        <div class="hidden sm:block mt-6 text-center">
            <p class="text-sm text-slate-500">アカウントをお持ちでない場合は <a href="{{ route('register') }}" class="text-cyan-600 hover:text-cyan-800 underline">こちらから登録</a></p>
        </div>
    </form>
</x-guest-layout>
