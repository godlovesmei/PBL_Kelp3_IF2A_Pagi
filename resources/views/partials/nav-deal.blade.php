<header x-data="{ open: false }" @keydown.escape="open = false" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo + Title -->
      <div class="flex items-center space-x-4">
        <a href="{{ route('pages.dealer.dashboard') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
          <x-application-logo class="h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
          <span class="hidden sm:inline ml-4 text-2xl font-semibold text-gray-900 dark:text-gray-100 select-none">
            Dealer Dashboard
          </span>
        </a>
      </div>

      <!-- Desktop User Dropdown -->
      <div class="hidden sm:flex sm:items-center">
        <div class="relative" x-data="{ dropdownOpen: false }" @keydown.escape="dropdownOpen = false" @click.away="dropdownOpen = false">
          <button
            @click="dropdownOpen = !dropdownOpen"
            type="button"
            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium
                   text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800
                   hover:text-gray-800 dark:hover:text-white
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
            aria-haspopup="true"
            :aria-expanded="dropdownOpen.toString()"
            aria-label="User menu"
          >
            <!-- Icon User (gear/settings icon) -->
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M11.983 13.931a2.003 2.003 0 100-4.006 2.003 2.003 0 000 4.006zM19.435 12.478c.03-.316.045-.638.045-.965s-.015-.649-.045-.965l2.122-1.654a.5.5 0 00.11-.638l-2-3.464a.5.5 0 00-.605-.22l-2.497 1a7.99 7.99 0 00-1.671-.965l-.378-2.65A.5.5 0 0014 2h-4a.5.5 0 00-.497.435l-.378 2.65a7.99 7.99 0 00-1.671.965l-2.497-1a.5.5 0 00-.605.22l-2 3.464a.5.5 0 00.11.638l2.122 1.654c-.03.316-.045.638-.045.965s.015.649.045.965L2.453 14.13a.5.5 0 00-.11.638l2 3.464a.5.5 0 00.605.22l2.497-1c.52.39 1.08.718 1.671.965l.378 2.65A.5.5 0 0010 22h4a.5.5 0 00.497-.435l.378-2.65a7.99 7.99 0 001.671-.965l2.497 1a.5.5 0 00.605-.22l2-3.464a.5.5 0 00-.11-.638l-2.122-1.654z"/>
            </svg>
            <!-- Chevron down -->
            <svg class="ml-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>

          <!-- Dropdown menu -->
          <div
            x-show="dropdownOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="origin-top-right absolute right-0 mt-2 w-52 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-20"
            role="menu"
            aria-orientation="vertical"
            tabindex="-1"
            style="display: none;"
          >
            <div class="py-1" role="none">
              <x-dropdown-link :href="route('pages.profile.edit')" role="menuitem" tabindex="-1" id="user-menu-item-0">
                {{ __('Profile & Settings') }}
              </x-dropdown-link>
              <form method="POST" action="{{ route('logout') }}" role="none">
                @csrf
                <x-dropdown-link
                  :href="route('logout')"
                  role="menuitem"
                  tabindex="-1"
                  onclick="event.preventDefault(); this.closest('form').submit();"
                >
                  {{ __('Log Out') }}
                </x-dropdown-link>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Hamburger -->
      <div class="flex items-center sm:hidden">
        <button
          @click="open = !open"
          :aria-expanded="open.toString()"
          aria-controls="mobile-menu"
          aria-label="Toggle menu"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition"
        >
          <svg :class="{ 'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg :class="{ 'block': open, 'hidden': !open }" class="hidden h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-2"
    id="mobile-menu"
    class="sm:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800"
  >
    <nav class="px-2 pt-2 pb-3 space-y-1">
      <a href="{{ route('pages.dealer.dashboard') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
      >
        Dashboard
      </a>

      <div class="border-t border-gray-200 dark:border-gray-700 mt-3 pt-3">
        <div class="px-3">
          <p class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ Auth::user()->name }}</p>
          <p class="text-gray-500 dark:text-gray-400 text-sm truncate">{{ Auth::user()->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
          @csrf
          <button
            type="submit"
            class="w-full text-left px-3 py-2 rounded-md text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition font-medium"
          >
            Log Out
          </button>
        </form>
      </div>
    </nav>
  </div>
</header>
