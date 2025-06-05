@props(['categories'])
<!-- Toggle button for mobile -->
<button id="filter-toggle"
    class="lg:hidden fixed top-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-md shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
    aria-expanded="false" aria-controls="filter-sidebar" aria-label="Toggle filters">
    Filters
</button>

<form action="{{ route('pages.shop') }}" method="GET"
      id="filter-sidebar"
      class="fixed top-0 left-0 z-40 h-full w-4/5 max-w-xs bg-white shadow-xl rounded-r-2xl p-5 pt-16 overflow-y-auto border border-gray-200 space-y-6 text-sm
             transform -translate-x-full transition-transform duration-300 ease-in-out
             lg:relative lg:translate-x-0 lg:max-w-none lg:w-1/5 lg:pt-5 lg:rounded-2xl">

    <!-- Section Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-4 lg:mb-2">Filters</h2>

    <!-- CATEGORY -->
    <div>
        <h3 class="text-gray-700 font-medium flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            Category
        </h3>
        <div class="flex flex-wrap gap-3">
            @foreach ($categories as $category)
                <label for="category-{{ $category }}"
                       class="flex items-center gap-2 border px-3 py-1.5 rounded-full cursor-pointer transition
                              hover:border-indigo-500 hover:bg-indigo-50 focus-within:ring-2 focus-within:ring-indigo-400 focus-within:outline-none"
                       tabindex="0">
                    <input id="category-{{ $category }}" type="checkbox" name="category[]" value="{{ $category }}"
                           class="accent-indigo-500 focus:ring-0 rounded"
                           {{ in_array($category, request()->get('category', [])) ? 'checked' : '' }}
                           onchange="onFilterChange()">
                    <span class="text-gray-600 capitalize">{{ $category }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- PRICE -->
    <div>
        <h3 class="text-gray-700 font-medium flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
            </svg>
            Price
        </h3>
        <div class="flex flex-wrap gap-3">
            @php
                $priceOptions = [
                    '<300' => '≤300M',
                    '>300' => '>300M',
                    '>900' => '>900M'
                ];
            @endphp

            @foreach ($priceOptions as $value => $label)
                <label for="price-{{ $value }}"
                       class="flex items-center gap-2 border px-3 py-1.5 rounded-full cursor-pointer transition
                              hover:border-green-500 hover:bg-green-50 focus-within:ring-2 focus-within:ring-green-400 focus-within:outline-none"
                       tabindex="0">
                    <input id="price-{{ $value }}" type="checkbox" name="price[]" value="{{ $value }}"
                           class="accent-green-500 focus:ring-0 rounded"
                           {{ in_array($value, request()->get('price', [])) ? 'checked' : '' }}
                           onchange="onFilterChange()">
                    <span class="text-gray-600">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Reset button -->
    <div>
        <button type="button" id="reset-filters"
                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg py-2 text-sm font-medium transition">
            Reset Filters
        </button>
    </div>
</form>

<script>
const toggleBtn = document.getElementById('filter-toggle');
const filterSidebar = document.getElementById('filter-sidebar');
const resetBtn = document.getElementById('reset-filters');
const isMobile = () => window.innerWidth < 1024;

// Toggle sidebar on mobile
toggleBtn.addEventListener('click', () => {
    const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
    toggleBtn.setAttribute('aria-expanded', !expanded);
    filterSidebar.classList.toggle('-translate-x-full');
});

// Close sidebar on mobile after filter changed (for better UX)
function onFilterChange() {
    filterSidebar.submit();

    if (isMobile()) {
        setTimeout(() => {
            filterSidebar.classList.add('-translate-x-full');
            toggleBtn.setAttribute('aria-expanded', false);
        }, 300);
    }
}

// Reset filters button functionality
resetBtn.addEventListener('click', (e) => {
    e.preventDefault(); // cegah default behavior button jika ada

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

    // Submit after a small delay agar perubahan state diterapkan dulu
    setTimeout(() => {
        filterSidebar.submit();
    }, 50);
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

// Handle window resize to sync sidebar state
window.addEventListener('resize', () => {
    if (!isMobile()) {
        filterSidebar.classList.remove('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', true);
    } else {
        filterSidebar.classList.add('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', false);
    }
});

// Init sidebar state on page load according to screen size
window.addEventListener('load', () => {
    if (isMobile()) {
        filterSidebar.classList.add('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', false);
    } else {
        filterSidebar.classList.remove('-translate-x-full');
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
</style>
