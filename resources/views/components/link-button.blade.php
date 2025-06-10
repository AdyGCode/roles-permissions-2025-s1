<a {{ $attributes->merge([
    'class' => 'inline-flex items-center
                px-4 py-2
                bg-gray-300 hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-400
                text-gray-800 hover:text-white
                border border-transparent rounded-md
                font-semibold text-xs
                uppercase tracking-widest
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                transition ease-in-out duration-150 '
    ]) }}>
    {{ $slot }}
</a>
