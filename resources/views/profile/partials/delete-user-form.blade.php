<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-600 flex items-center gap-2">
            <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i> アカウントの削除
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            アカウントを削除すると、すべてのリソースとデータが完全に消去されます。アカウントを削除する前に、保持しておきたいデータや情報をダウンロードしてください。
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >アカウントを削除する</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-800">
                本当にアカウントを削除してもよろしいですか？
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                アカウントを削除すると、すべてのリソースとデータが完全に消去されます。アカウントを完全に削除することを確認するため、パスワードを入力してください。
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="パスワード" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="パスワード"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    キャンセル
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    アカウントを削除
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
