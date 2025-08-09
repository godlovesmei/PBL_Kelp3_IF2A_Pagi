<div class="mb-6">
    <label class="block text-sm font-semibold mb-2">SELECT CATEGORY & MODEL:</label>
    <div class="flex items-center gap-2">
        {{-- Category Dropdown --}}
        <select id="categorySelect" name="category"
            class="border border-gray-300 px-3 py-1 w-40 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="" disabled {{ !$selectedCategory ? 'selected' : '' }}>Select category</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        {{-- Model Dropdown --}}
        <select id="modelSelect" name="car_id"
            class="border border-gray-300 px-3 py-1 w-48 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="" disabled {{ !$selected ? 'selected' : '' }}>Select a model</option>
            @foreach ($models as $car)
                <option value="{{ $car->id }}" data-category="{{ $car->category }}"
                    {{ $selected == $car->id ? 'selected' : '' }}>
                    {{ $car->model }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const catSelect = document.getElementById('categorySelect');
        const modelSelect = document.getElementById('modelSelect');

        // Filter models by selected category
        function filterModels() {
            const selectedCat = catSelect.value;
            let foundVisible = false;
            for (const opt of modelSelect.options) {
                if (!opt.value) continue; // skip placeholder
                if (opt.dataset.category === selectedCat) {
                    opt.style.display = '';
                    if (!foundVisible) {
                        modelSelect.value = opt.value;
                        foundVisible = true;
                    }
                } else {
                    opt.style.display = 'none';
                }
            }
            if (!foundVisible) {
                modelSelect.value = '';
            }
        }

        catSelect.addEventListener('change', filterModels);

        // Jika sudah ada selectedCategory dari server, jalankan filter otomatis
        @if ($selectedCategory)
            filterModels();
        @endif
    });
</script>
