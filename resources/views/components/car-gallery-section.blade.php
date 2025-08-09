<div x-data="{
    galleryTab: 'exterior',
    exteriorImages: @js($eksteriorImages), // [{url:..., caption:...}, ...]
    interiorImages: @js($interiorImages), // [{url:..., caption:...}, ...]
    showModal: false,
    modalList: [],
    modalIndex: 0,
    get modalImage() { return this.modalList[this.modalIndex] || {}; },
    openModal(list, idx, $event) {
        this.modalList = list;
        this.modalIndex = idx;
        this.showModal = true;
        $event?.stopPropagation();
    },
    closeModal() { this.showModal = false; },
    resetModal() {
        this.modalList = [];
        this.modalIndex = 0;
    },
    prevImage() { if (this.modalIndex > 0) this.modalIndex--; },
    nextImage() { if (this.modalIndex < this.modalList.length - 1) this.modalIndex++; },
    handleKey(e) {
        if (!this.showModal) return;
        if (e.key === 'ArrowLeft') this.prevImage();
        if (e.key === 'ArrowRight') this.nextImage();
        if (e.key === 'Escape') this.closeModal();
    }
}" class="w-full bg-gray-50 py-20">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-12">
        <div class="flex justify-center mb-10" data-aos="zoom-in">
            <nav class="inline-flex rounded-full shadow-sm bg-gray-100 p-1 relative">
                <button @click="galleryTab = 'exterior'"
                    :class="galleryTab === 'exterior'
                        ?
                        'bg-gradient-to-r from-red-600 to-black text-white shadow-lg scale-105' :
                        'text-gray-800 hover:bg-red-50 border border-red-200'"
                    class="transition-all duration-200 px-6 py-2 rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-red-400 flex items-center gap-2"
                    aria-label="View exterior images" type="button" data-aos="fade-right">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6m14 0a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2m14 0v3a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3" />
                    </svg>
                    Exterior
                </button>
                <button @click="galleryTab = 'interior'"
                    :class="galleryTab === 'interior'
                        ?
                        'bg-gradient-to-r from-red-600 to-black text-white shadow-lg scale-105' :
                        'text-gray-800 hover:bg-red-50 border border-red-200'"
                    class="transition-all duration-200 px-6 py-2 rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-red-400 flex items-center gap-2"
                    aria-label="View interior images" type="button" data-aos="fade-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Interior
                </button>
            </nav>
        </div>
        <div @keydown.window="handleKey($event)" x-cloak>
            <!-- Exterior Tab -->
            <template x-if="galleryTab === 'exterior'">
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-center" data-aos="fade-up">Exterior Images</h3>
                    <template x-if="exteriorImages.length > 0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                            <template x-for="(img, idx) in exteriorImages" :key="idx">
                                <div class="relative group cursor-pointer transition hover:scale-105"
                                    @click="openModal(exteriorImages, idx, $event)" :data-aos="'zoom-in-up'"
                                    :data-aos-delay="(idx % 3) * 100">
                                    <img :src="img.url" alt="Exterior"
                                        class="w-full aspect-[16/9] object-cover rounded-xl shadow border border-gray-100 transition" />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/30 transition rounded-xl">
                                        <span
                                            class="text-xs font-semibold text-white bg-black/60 px-2 py-1 rounded">View
                                            Image</span>
                                    </div>
                                    <!-- Caption -->
                                    <div class="text-center mt-2 text-xs text-gray-600" x-text="img.caption"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="exteriorImages.length === 0">
                        <p class="text-gray-400 text-center italic">No exterior images available.</p>
                    </template>
                </div>
            </template>
            <!-- Interior Tab -->
            <template x-if="galleryTab === 'interior'">
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-center" data-aos="fade-up">Interior Images</h3>
                    <template x-if="interiorImages.length > 0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                            <template x-for="(img, idx) in interiorImages" :key="idx">
                                <div class="relative group cursor-pointer transition hover:scale-105"
                                    @click="openModal(interiorImages, idx, $event)" :data-aos="'zoom-in-up'"
                                    :data-aos-delay="(idx % 3) * 100">
                                    <img :src="img.url" alt="Interior"
                                        class="w-full aspect-[16/9] object-cover rounded-xl shadow border border-gray-100 transition" />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/30 transition rounded-xl">
                                        <span
                                            class="text-xs font-semibold text-white bg-black/60 px-2 py-1 rounded">View
                                            Image</span>
                                    </div>
                                    <!-- Caption -->
                                    <div class="text-center mt-2 text-xs text-gray-600" x-text="img.caption"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="interiorImages.length === 0">
                        <p class="text-gray-400 text-center italic">No interior images available.</p>
                    </template>
                </div>
            </template>
            <!-- Modal -->
            <div x-show="showModal" x-transition.opacity @click.self="closeModal()" @after-leave="resetModal()"
                class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
                style="backdrop-filter: blur(2px);" data-aos="zoom-in">
                <div class="relative">
                    <button @click="closeModal()"
                        class="absolute top-2 right-2 text-white bg-black/50 rounded-full p-2 hover:bg-white hover:text-black focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        aria-label="Close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <button @click="prevImage()" x-show="modalIndex > 0"
                        class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-black/50 hover:bg-blue-500 text-white px-2 py-1 rounded-l-lg transition focus:outline-none focus:ring-2 focus:ring-blue-400"
                        aria-label="Previous image">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <img :src="modalImage.url"
                        class="max-w-3xl w-full max-h-[80vh] rounded-xl shadow-xl transition-transform duration-300 bg-white object-contain"
                        alt="Gallery preview">
                    <!-- Caption + Dot Indicators (NO TUMPANG TINDIH) -->
                    <div
                        class="absolute bottom-3 left-1/2 -translate-x-1/2 w-max flex flex-col items-center gap-1 z-50">
                        <div class="text-base font-medium text-white bg-black/60 px-3 py-1 rounded shadow"
                            x-text="modalImage.caption"></div>
                        <div class="flex gap-1 mt-1">
                            <template x-for="(img, dotIdx) in modalList" :key="dotIdx">
                                <span
                                    :class="dotIdx === modalIndex ?
                                        'bg-blue-500' :
                                        'bg-white/70 hover:bg-blue-300'"
                                    class="inline-block w-2 h-2 rounded-full transition-all ring-1 ring-white mx-0.5"></span>
                            </template>
                        </div>
                    </div>
                    <button @click="nextImage()" x-show="modalIndex < modalList.length-1"
                        class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-black/50 hover:bg-blue-500 text-white px-2 py-1 rounded-r-lg transition focus:outline-none focus:ring-2 focus:ring-blue-400"
                        aria-label="Next image">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
