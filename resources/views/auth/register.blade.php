<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="お名前" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="パスワード" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="パスワード(確認用)" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row-reverse items-center justify-between mt-8 gap-4">
            <x-primary-button class="w-full sm:w-auto">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> アカウント登録
            </x-primary-button>
            <a href="{{ route('login') }}" class="text-sm text-cyan-600 hover:text-cyan-800 underline block text-center sm:hidden mt-2">ログイン画面へ</a>
        </div>
        <div class="hidden sm:block mt-6 text-center">
             <a class="underline text-sm text-slate-500 hover:text-slate-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500" href="{{ route('login') }}">
                すでにアカウントをお持ちですか？ログインはこちら
            </a>
        </div>
    </form>
</x-guest-layout>
