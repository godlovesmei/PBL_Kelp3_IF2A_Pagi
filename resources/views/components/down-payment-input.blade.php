@props(['carPrice'])

<div class="mt-6">
    <x-input-label for="dpInput" :value="('Down Payment (%)')" />
    <div class="flex items-center gap-2 mt-1">
        <x-text-input 
            id="dpInput" 
            name="down_payment" 
            type="number" 
            value="30" 
            min="30" 
            max="50" 
            placeholder="30-50%" 
            class="w-28"
            oninput="validateDP(this)"
            required
        />
        <span class="text-sm">%</span>
        <button type="button" onclick="showSimulation()"
            class="bg-red-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-red-700 transition">
            Simulate
        </button>
    </div>
    <p class="text-xs text-gray-500 mt-1">*Enter a number between 30% and 50%</p>
</div>