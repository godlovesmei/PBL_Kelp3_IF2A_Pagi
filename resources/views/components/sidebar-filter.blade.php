@props(['categories', 'sortOptions' => [
    'newest' => 'Newest',
    'price_asc' => 'Price: Low to High',
    'price_desc' => 'Price: High to Low',
]])

<!-- Mobile Filter Toggle Button -->
<button id="filter-toggle"
    class="lg:hidden fixed top-4 left-4 z-50 bg-cyan-500 text-white p-3 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
    aria-expanded="false" aria-controls="filter-sidebar" aria-label="Toggle filters">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="lg:hidden fixed inset-0 z-40 bg-black/30 backdrop-blur-sm transition-opacity duration-200 opacity-0 pointer-events-none"></div>

<form action="{{ route('pages.shop') }}" method="GET"
      id="filter-sidebar"
      class="fixed top-0 left-0 z-50 h-full w-full max-w-xs bg-white dark:bg-gray-900 shadow-2xl p-0 pt-0 border-r border-gray-200 dark:border-gray-800 space-y-0 text-sm
             transform -translate-x-full transition-transform duration-300 ease-in-out
             rounded-none
             lg:relative lg:z-10 lg:h-auto lg:shadow-none lg:max-w-none lg:w-1/5 lg:pt-5 lg:rounded-2xl lg:bg-white lg:dark:bg-gray-900 lg:space-y-6 lg:border-r-0">

    <!-- Header Mobile -->
    <div class="flex items-center justify-between p-5 border-b border-gray-100 dark:border-gray-800 lg:hidden">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Filters</h2>
        <button type="button"
            id="filter-close"
            class="p-2 rounded-full text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            aria-label="Close filters">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <!-- Header Desktop -->
    <div class="hidden lg:block px-5 pt-2 pb-0">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Filters</h2>
    </div>

    <div class="px-5 py-4 lg:py-0 space-y-6">
        <!-- SORT BY (Professional touch) -->
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                <svg class="inline mb-1 mr-1 w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8h13M3 16h9"/>
                </svg>
                Sort by
            </label>
            <select name="sort" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($sortOptions as $val => $label)
                    <option value="{{ $val }}" @if(request('sort') === $val) selected @endif>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <hr class="border-gray-200 dark:border-gray-700">

        <!-- CATEGORY -->
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                <svg class="inline mb-1 mr-1 w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Category
            </label>
            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $category)
                    <label for="category-{{ $category }}"
                        class="flex items-center gap-2 border px-3 py-2 rounded-full cursor-pointer transition
                            hover:border-indigo-500 hover:bg-indigo-50 dark:hover:border-indigo-400 dark:hover:bg-indigo-900
                            focus-within:ring-2 focus-within:ring-indigo-400 focus-within:outline-none text-gray-700 dark:text-gray-200"
                        tabindex="0">
                        <input id="category-{{ $category }}" type="checkbox" name="category[]" value="{{ $category }}"
                            class="accent-indigo-500 focus:ring-0 rounded w-5 h-5"
                            {{ in_array($category, request()->get('category', [])) ? 'checked' : '' }}
                            onchange="onFilterChange()">
                        <span class="capitalize">{{ $category }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <hr class="border-gray-200 dark:border-gray-700">

        <!-- PRICE -->
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                <svg class="inline mb-1 mr-1 w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                </svg>
                Price
            </label>
            <div class="flex flex-wrap gap-2">
                @php
                    $priceOptions = [
                        '<300' => '≤300M',
                        '>300' => '>300M',
                        '>900' => '>900M'
                    ];
                @endphp

                @foreach ($priceOptions as $value => $label)
                    <label for="price-{{ $value }}"
                        class="flex items-center gap-2 border px-3 py-2 rounded-full cursor-pointer transition
                            hover:border-green-500 hover:bg-green-50 dark:hover:border-green-400 dark:hover:bg-green-900
                            focus-within:ring-2 focus-within:ring-green-400 focus-within:outline-none text-gray-700 dark:text-gray-200"
                        tabindex="0">
                        <input id="price-{{ $value }}" type="checkbox" name="price[]" value="{{ $value }}"
                            class="accent-green-500 focus:ring-0 rounded w-5 h-5"
                            {{ in_array($value, request()->get('price', [])) ? 'checked' : '' }}
                            onchange="onFilterChange()">
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Add more filter sections here as needed -->

        <!-- Reset button -->
        <div class="pt-4">
            <button type="button" id="reset-filters"
                class="w-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg py-3 text-base font-semibold shadow transition">
                Reset Filters
            </button>
        </div>
    </div>
</form>

<script>
const toggleBtn = document.getElementById('filter-toggle');
const filterSidebar = document.getElementById('filter-sidebar');
const filterOverlay = document.getElementById('sidebar-overlay');
const resetBtn = document.getElementById('reset-filters');
const closeBtn = document.getElementById('filter-close');
const isMobile = () => window.innerWidth < 1024;

// Toggle sidebar and overlay on mobile
function openSidebar() {
    filterSidebar.classList.remove('-translate-x-full');
    filterOverlay.classList.remove('opacity-0','pointer-events-none');
    filterOverlay.classList.add('opacity-100');
    toggleBtn.setAttribute('aria-expanded', true);
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    filterSidebar.classList.add('-translate-x-full');
    filterOverlay.classList.remove('opacity-100');
    filterOverlay.classList.add('opacity-0','pointer-events-none');
    toggleBtn.setAttribute('aria-expanded', false);
    document.body.style.overflow = '';
}

toggleBtn.addEventListener('click', openSidebar);
if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
filterOverlay.addEventListener('click', closeSidebar);

// Filter auto close after check/uncheck (mobile only)
function onFilterChange() {
    filterSidebar.submit();
    if (isMobile()) {
        setTimeout(() => closeSidebar(), 250);
    }
}

// Reset filters button functionality
resetBtn.addEventListener('click', (e) => {
    e.preventDefault();
    // Clear all input fields manually
    Array.from(filterSidebar.elements).forEach(el => {
        if (el.type === 'checkbox' || el.type === 'radio') {
            el.checked = false;
        } else if (el.tagName === 'SELECT') {
            el.selectedIndex = 0;
        } else if (el.type === 'text' || el.type === 'number' || el.type === 'search') {
            el.value = '';
        }
    });
    setTimeout(() => filterSidebar.submit(), 50);
});

// Alert if no cars found and reset filters
document.addEventListener('DOMContentLoaded', () => {
    const noCarsMessage = document.querySelector('#noCarsMessage');
    if (noCarsMessage) {
        alert('No cars match your search criteria. All filters will be reset.');
        Array.from(filterSidebar.elements).forEach(el => {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else if (el.type === 'text' || el.type === 'number' || el.type === 'search') {
                el.value = '';
            }
        });
        setTimeout(() => filterSidebar.submit(), 50);
    }
});

// Responsive handling
window.addEventListener('resize', () => {
    if (!isMobile()) {
        filterSidebar.classList.remove('-translate-x-full');
        filterOverlay.classList.add('opacity-0','pointer-events-none');
        toggleBtn.setAttribute('aria-expanded', true);
        document.body.style.overflow = '';
    } else {
        filterSidebar.classList.add('-translate-x-full');
        filterOverlay.classList.remove('opacity-100');
        filterOverlay.classList.add('opacity-0','pointer-events-none');
        toggleBtn.setAttribute('aria-expanded', false);
    }
});
window.addEventListener('load', () => {
    if (isMobile()) {
        filterSidebar.classList.add('-translate-x-full');
        filterOverlay.classList.remove('opacity-100');
        filterOverlay.classList.add('opacity-0','pointer-events-none');
        toggleBtn.setAttribute('aria-expanded', false);
    } else {
        filterSidebar.classList.remove('-translate-x-full');
        filterOverlay.classList.add('opacity-0','pointer-events-none');
        toggleBtn.setAttribute('aria-expanded', true);
    }
});
</script>

<style>
    /* Scrollbar for sidebar */
    #filter-sidebar::-webkit-scrollbar {
        width: 8px;
    }
    #filter-sidebar::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 8px;
    }
    #filter-sidebar::-webkit-scrollbar-thumb {
        background-color: #a78bfa;
        border-radius: 8px;
    }
    /* Mobile sidebar overlay transition */
    #sidebar-overlay {
        transition-property: opacity;
    }
</style>
