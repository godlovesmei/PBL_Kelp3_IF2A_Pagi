<div class="fixed top-4 right-4 z-50" x-data="{ open: false }">
    <button @click="open = !open" class="p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
        :aria-expanded="open" aria-label="Toggle menu">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
        </svg>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
        @if ($dealer)
            <a href="{{ route('pages.dealer.dashboard') }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('pages.home') }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Home</a>
            <a href="{{ route('pages.shop') }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Shop</a>
            <a href="{{ route('pages.about') }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">About</a>
            <a href="{{ route('pages.contact') }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Contact</a>
            <a href="{{ route('pages.wishlist') }}"
                class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:text-[#7d5a3e] dark:hover:text-[#c3a089] hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Wishlist
                <svg class="w-5 h-5 text-black dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                </svg>
            </a>
        @endif
    </div>
</div>
