<div x-show="modalOpen" x-cloak
    class="fixed inset-0 z-40 flex items-center justify-center bg-black/30"
    x-transition>
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-sm relative">
        <button @click="modalOpen=false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        {{ $slot }}
    </div>
</div>
