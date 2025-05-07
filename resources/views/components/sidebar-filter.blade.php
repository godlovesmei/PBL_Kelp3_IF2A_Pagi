<form action="{{ route('pages.shop') }}" method="GET" class="w-full lg:w-1/5 bg-white shadow-lg rounded-xl p-4 max-h-[85vh] overflow-y-auto border border-gray-200" id="filter-form">
    <!-- CATEGORY Section -->
    <div class="mb-6">
        <h3 class="font-semibold text-base sm:text-lg mb-3 text-gray-900 border-b border-gray-300 pb-2">Filter by Category</h3>
        <ul class="space-y-2">
            @foreach ($categories as $category)
            <li class="flex items-center">
                <input id="category-{{ $category }}" type="checkbox" name="category[]" value="{{ $category }}"
                       class="mr-2 accent-blue-500 focus:ring focus:ring-blue-300 h-4 w-4"
                       {{ in_array($category, request()->get('category', [])) ? 'checked' : '' }}
                       onchange="document.getElementById('filter-form').submit();">
                <label for="category-{{ $category }}" class="text-sm font-medium text-gray-700 hover:text-blue-500 cursor-pointer">
                    {{ $category }}
                </label>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- PRICE Section -->
    <div>
        <h3 class="font-semibold text-base sm:text-lg mb-3 text-gray-900 border-b border-gray-300 pb-2">Filter by Price</h3>
        <ul class="space-y-2">
            <li class="flex items-center">
                <input id="price-below-300" type="checkbox" name="price[]" value="<300"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300 h-4 w-4"
                       {{ in_array('<300', request()->get('price', [])) ? 'checked' : '' }}
                       onchange="document.getElementById('filter-form').submit();">
                <label for="price-below-300" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Below 300 Million
                </label>
            </li>
            <li class="flex items-center">
                <input id="price-above-300" type="checkbox" name="price[]" value=">300"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300 h-4 w-4"
                       {{ in_array('>300', request()->get('price', [])) ? 'checked' : '' }}
                       onchange="document.getElementById('filter-form').submit();">
                <label for="price-above-300" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Above 300 Million
                </label>
            </li>
            <li class="flex items-center">
                <input id="price-above-900" type="checkbox" name="price[]" value=">900"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300 h-4 w-4"
                       {{ in_array('>900', request()->get('price', [])) ? 'checked' : '' }}
                       onchange="document.getElementById('filter-form').submit();">
                <label for="price-above-900" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Above 900 Million
                </label>
            </li>
        </ul>
    </div>
</form>