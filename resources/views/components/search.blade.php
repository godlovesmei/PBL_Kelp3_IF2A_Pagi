<div
    x-data="{ search: @js(request('search')) }"
    class="relative w-full"
>
    <form
        action="{{ route('pages.shop') }}"
        method="GET"
        @submit="$event.target.search.value.trim() === '' ? $event.preventDefault() : null"
        class="w-full h-10 flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-full px-3 shadow-sm backdrop-blur
               transition duration-200
               hover:border-blue-400 hover:shadow-md dark:hover:border-blue-400"
        style="min-height: 40px"
    >
        <svg class="w-4 h-4 text-blue-500 dark:text-blue-300 mr-2" viewBox="0 0 24 24" fill="currentColor">
            <path d="m20.267 19.207-4.818-4.818A6.97 6.97 0 0 0 17 10a7 7 0 1 0-7 7 6.97 6.97 0 0 0 4.389-1.55l4.818 4.817a.75.75 0 0 0 1.06 0 .75.75 0 0 0 0-1.06M4.5 10c0-3.033 2.467-5.5 5.5-5.5s5.5 2.467 5.5 5.5-2.467 5.5-5.5 5.5-5.5-2.467-5.5-5.5"/>
        </svg>
        <input
            x-ref="input"
            type="text"
            name="search"
            x-model="search"
            autocomplete="off"
            placeholder="Search"
            class="flex-1 bg-transparent focus:ring-0 border-0 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
        />
        <!-- Clear Button -->
        <button
            type="button"
            x-show="search"
            @click="search = ''; $refs.input.focus()"
            class="ml-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-200 transition"
            tabindex="-1"
            aria-label="Clear"
            x-cloak
        >
            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor">
                <path d="M12.243 11.182a.75.75 0 1 1-1.06 1.06L8 9.062l-3.182 3.182a.75.75 0 0 1-1.06 0 .75.75 0 0 1 0-1.06L6.938 8 3.757 4.818a.75.75 0 1 1 1.06-1.06L8 6.938l3.182-3.182a.75.75 0 1 1 1.06 1.06L9.062 8z"/>
            </svg>
        </button>
    </form>
</div>

