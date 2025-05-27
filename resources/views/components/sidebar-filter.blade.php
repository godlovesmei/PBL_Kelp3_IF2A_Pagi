<form action="{{ route('pages.shop') }}" method="GET"
      class="w-full lg:w-1/5 bg-white shadow-xl rounded-2xl p-5 max-h-[90vh] overflow-y-auto border border-gray-200 space-y-6 text-sm"
      id="filter-form">

    <!-- Section Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Filters</h2>

    <!-- CATEGORY -->
    <div>
        <h3 class="text-gray-700 font-medium flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            Category
        </h3>
        <div class="flex flex-wrap gap-3">
            @foreach ($categories as $category)
                <label for="category-{{ $category }}"
                       class="flex items-center gap-2 border px-3 py-1.5 rounded-full cursor-pointer transition hover:border-indigo-500 hover:bg-indigo-50">
                    <input id="category-{{ $category }}" type="checkbox" name="category[]" value="{{ $category }}"
                           class="accent-indigo-500 focus:ring-0 rounded"
                           {{ in_array($category, request()->get('category', [])) ? 'checked' : '' }}
                           onchange="document.getElementById('filter-form').submit();">
                    <span class="text-gray-600 capitalize">{{ $category }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- PRICE -->
    <div>
        <h3 class="text-gray-700 font-medium flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                       class="flex items-center gap-2 border px-3 py-1.5 rounded-full cursor-pointer transition hover:border-green-500 hover:bg-green-50">
                    <input id="price-{{ $value }}" type="checkbox" name="price[]" value="{{ $value }}"
                           class="accent-green-500 focus:ring-0 rounded"
                           {{ in_array($value, request()->get('price', [])) ? 'checked' : '' }}
                           onchange="document.getElementById('filter-form').submit();">
                    <span class="text-gray-600">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const noCarsMessage = document.querySelector('#noCarsMessage');
        if (noCarsMessage) {
            alert('No cars match your search criteria. All filters will be reset.');
            const filterForm = document.getElementById('filter-form');
            if (filterForm) {
                filterForm.reset();
                filterForm.submit();
            }
        }
    });
</script>
