<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-cyan-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-cyan-700 focus:bg-cyan-700 active:bg-cyan-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md w-full sm:w-auto']) }}>
    {{ $slot }}
</button>
