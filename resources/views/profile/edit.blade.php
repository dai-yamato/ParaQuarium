<x-layouts.app>
    <div class="max-w-3xl mx-auto py-8">
        <h2 class="font-bold text-2xl text-slate-800 flex items-center gap-2 mb-6">
            <i data-lucide="user" class="w-6 h-6 text-cyan-600"></i> プロフィール設定
        </h2>

        <div class="space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-slate-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm border border-slate-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm border border-slate-200 rounded-2xl border-red-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
