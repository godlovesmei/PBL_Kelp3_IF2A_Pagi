@props([
    'number',
    'title',
])

<div class="border shadow bg-white">
    <button
        @click="
            if (openSections.includes({{ $number }})) {
                openSections = openSections.filter(i => i !== {{ $number }})
            } else {
                openSections.push({{ $number }})
            }
        "
        class="w-full flex items-center justify-between px-6 py-4 font-semibold text-left text-gray-800 focus:outline-none"
    >
        <span>{{ $title }}</span>
        <svg
            :class="{ 'rotate-180': openSections.includes({{ $number }}) }"
            class="w-5 h-5 transition-transform"
            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="openSections.includes({{ $number }})" x-transition class="px-6 pb-4 text-gray-700">
        {{ $slot }}
    </div>
</div>
