@extends('layouts.user')

@section('title', 'Car Details')

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('galleryViewer', () => ({
            showModal: false,
            modalImage: {},
            modalIndex: 0,
            modalList: [],
            _oldOverflow: '',
            _lastActiveEl: null,
            openModal(list, idx, $event = null) {
                this.modalList = list;
                this.modalIndex = idx;
                this.modalImage = list[idx]; // Sekarang ini adalah object {url, caption}
                this.showModal = true;
                this._lastActiveEl = $event?.currentTarget || document.activeElement;
                if (document.body.style.overflow !== 'hidden') {
                    this._oldOverflow = document.body.style.overflow;
                    document.body.style.overflow = 'hidden';
                }
            },
            closeModal() {
                this.showModal = false;
                document.body.style.overflow = this._oldOverflow || '';
                this._oldOverflow = '';
                if (this._lastActiveEl && typeof this._lastActiveEl.focus === 'function') {
                    this._lastActiveEl.focus();
                }
                this._lastActiveEl = null;
            },
            resetModal() {
                this.modalImage = {};
                this.modalList = [];
                this.modalIndex = 0;
            },
            nextImage() {
                if (this.modalIndex < this.modalList.length - 1) {
                    this.modalIndex++;
                    this.modalImage = this.modalList[this.modalIndex];
                }
            },
            prevImage() {
                if (this.modalIndex > 0) {
                    this.modalIndex--;
                    this.modalImage = this.modalList[this.modalIndex];
                }
            },
            handleKey(e) {
                if (!this.showModal) return;
                if (e.key === 'Escape') this.closeModal();
                if (e.key === 'ArrowRight') this.nextImage();
                if (e.key === 'ArrowLeft') this.prevImage();
            }
        }));
    });
</script>
@endpush

@section('content')
<div
    x-data="{
        colors: {{ $car->colors->map(fn($color) => [
            'id' => $color->id,
            'name' => $color->color_name,
            'hex' => $color->hex ?? '#FFFFFF',
            'image' => asset('images/' . $color->image_path)
        ])->toJson() }},
        selectedColor: null,
        galleryTab: 'eksterior',
        eksteriorImages: {{ $exteriorGalleries->map(fn($g) => asset('storage/galleries/' . $g->image_path))->toJson() }},
        interiorImages: {{ $interiorGalleries->map(fn($g) => asset('storage/galleries/' . $g->image_path))->toJson() }},
        init() {
            this.selectedColor = this.colors[0] ?? { hex: '#FFFFFF', name: 'Default', image: '{{ asset('images/default-car.jpg') }}' };
        }
    }"
    x-init="init()"
>
    <!-- Car Section with Dynamic Background -->
    <div class="relative flex flex-col justify-between pt-[130px] pb-10">
        <div :style="`background: linear-gradient(to bottom, ${selectedColor.hex.startsWith('#') ? selectedColor.hex : '#' + selectedColor.hex}, #ffffff 80%)`"
             class="absolute inset-0 -z-10 transition-colors duration-500"></div>
        <div class="text-center max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-10">{{ $car->brand }} {{ $car->model }}</h1>
            <div class="relative overflow-hidden w-full">
                <img :src="selectedColor.image"
                     :alt="selectedColor.name"
                     class="mx-auto w-full max-w-md rounded-lg shadow-lg">
            </div>
            <div class="mt-4 text-center">
                <p class="text-lg font-medium"><span x-text="selectedColor.name"></span></p>
            </div>
            <p class="text-xl font-bold mt-6">Rp{{ number_format($car->price, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Gallery Section -->
<x-car-gallery-section
    :car="$car"
    :eksterior-images="$exteriorGalleries->map(fn($g) => ['url' => asset('storage/galleries/' . $g->image_path), 'caption' => $g->caption])->values()"
    :interior-images="$interiorGalleries->map(fn($g) => ['url' => asset('storage/galleries/' . $g->image_path), 'caption' => $g->caption])->values()"
/>
    <!-- Specifications Section -->
    <div class="bg-gray-50 text-center p-6">
        <h2 class="text-xl font-semibold mb-6 mt-10">Specifications</h2>
        <div class="bg-gray-100 p-6 rounded-lg shadow-md inline-block text-left">
            @if(!empty($car->specifications))
                <ul class="text-sm text-gray-800 space-y-2 list-disc list-inside">
                    @foreach(explode(',', $car->specifications) as $spec)
                        <li>{{ trim($spec) }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Specifications are not available for this car.</p>
            @endif
        </div>
    </div>

    <!-- Notes -->
    <div class="bg-gray-50 text-center p-10">
        <h3 class="text-md font-semibold text-gray-800 mt-10">Notes</h3>
        <ul class="text-xs text-gray-800 mt-2 space-y-2 list-inside list-disc">
            <li>The displayed price is the OTR Jakarta price for the first car ownership, and may change at any time without prior notice.</li>
            <li>Changes in color, materials, and features may occur at any time without prior notification.</li>
            <li>Specifications, features, and materials may differ from the actual vehicle being sold.</li>
        </ul>
    </div>

    <!-- Form Section pakai komponen -->
    <x-car-purchase-form :car="$car" :carPrice="$carPrice" />
</div>

@include('components.floating-menu')
@endsection
