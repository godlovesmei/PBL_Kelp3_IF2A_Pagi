@props([
    'value' => '',
    'disabled' => false,
])

<textarea {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => '
                w-full
                px-3 py-2
                border border-gray-300
                rounded-lg shadow-sm
                text-sm text-gray-900
                placeholder-gray-400

                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500

                dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-500
                dark:focus:border-indigo-500 dark:focus:ring-indigo-500
                transition
            ',
    ]) }}>{{ old($attributes->get('name')) ?? $value }}</textarea>
