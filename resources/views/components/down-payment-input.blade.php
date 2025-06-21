@props([
    'value' => old('down_payment_percent', 30),
    'min' => 30,
    'max' => 70,
])

<div class="space-y-2">
    <label for="down_payment_percent" class="block text-sm font-medium text-gray-700">
        Down Payment (%)
    </label>
    <div class="flex items-center gap-2">
        <input
            type="number"
            id="down_payment_percent"
            name="down_payment_percent"
            class="form-input border border-gray-300 rounded-md px-3 py-2 w-24"
            min="{{ $min }}"
            max="{{ $max }}"
            step="1"
            value="{{ $value }}"
            required
        >
        <span class="text-sm">%</span>
    </div>
    @error('down_payment_percent')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
