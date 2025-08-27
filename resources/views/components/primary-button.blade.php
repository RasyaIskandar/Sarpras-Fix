<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
            text-white font-medium text-sm rounded-lg shadow-md transition duration-200 ease-in-out focus:outline-none
            focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
    ]) }}
>
    {{ $slot }}
</button>