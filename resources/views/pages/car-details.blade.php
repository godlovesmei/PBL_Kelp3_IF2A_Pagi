@extends('layouts.customer')

@section('title', 'Car Details')

@section('content')

<div x-data="{
    colors: {{ $car->colors->map(fn($color) => ['id' => $color->id, 'name' => $color->color_name, 'hex' => $color->hex ?? 'FFFFFF', 'image' => asset('images/' . $color->image_path)])->toJson() }},
    selectedColor: null,
    init() {
        this.selectedColor = this.colors[0] ?? { hex: 'FFFFFF', name: 'Default', image: '{{ asset('images/default-car.jpg') }}' }; // Default color if none available
    }
}">
    <!-- Car Section with Dynamic Background -->
    <div class="relative flex flex-col justify-between pt-[130px] pb-10">
        <!-- Dynamic Background -->
        <div :style="`background: linear-gradient(to bottom, #${selectedColor.hex}, #ffffff 80%);`" 
             class="absolute inset-0 -z-10 transition-colors duration-500"></div>

        <!-- Car Content Section -->
        <div class="text-center max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-10">{{ $car->model }}</h1>

            <!-- Car Image -->
            <div class="relative overflow-hidden w-full">
                <img :src="selectedColor.image" 
                     :alt="selectedColor.name" 
                     class="mx-auto w-full max-w-md rounded-lg shadow-lg">
            </div>

            <!-- Color Name -->
            <div class="mt-4 text-center">
                <p class="text-lg font-medium"><span x-text="selectedColor.name"></span></p>
            </div>

            <!-- Price -->
            <p class="text-xl font-bold mt-6">Rp{{ number_format($car->price, 0, ',', '.') }}</p>
        </div>
    </div>

 <!-- Specifications Section -->
    <div class="bg-gray-50 text-center mt-30 p-6">
        <h2 class="text-xl font-semibold mb-4 mt-10">Specifications</h2>
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
</div>

    <!-- Form Section -->
    <div class="flex justify-center items-center bg-gray-50">
        <div class="bg-gray-100 rounded-xl p-8 w-[700px] shadow-lg mt-10">
            <h2 class="text-center text-xl font-semibold mb-6">Submit Purchase Request</h2>

            <!-- Form Input Fields -->
            <div class="p-4 mb-4 space-y-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Full Name:</label>
                    <input type="text" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your full name">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">ID Number:</label>
                    <input type="text" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter ID number">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Full Address:</label>
                    <textarea class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your full address"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">WhatsApp Number:</label>
                    <input type="text" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter WhatsApp number">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email:</label>
                    <input type="email" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter email">
                </div>
            </div>

            <!-- Upload Documents -->
            <div class="mb-6">
                <p class="font-bold mb-4">Upload Supporting Documents</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold">ID Card (KTP):</label>
                        <input type="file" class="w-full text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Tax ID (NPWP):</label>
                        <input type="file" class="w-full text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Family Card (KK):</label>
                        <input type="file" class="w-full text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Salary Slip:</label>
                        <input type="file" class="w-full text-sm border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Down Payment Input and Button -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">DOWN PAYMENT:</label>
                <div class="flex items-center gap-2">
                    <input 
                        type="number" 
                        id="dpInput" 
                        value="30" 
                        min="30" 
                        max="50" 
                        placeholder="Enter Down Payment (30-50%)"
                        class="border border-gray-300 px-3 py-1 w-28 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="validateDP(this)"
                    />
                    <span class="text-sm">%</span>
                    <button onclick="showSimulation()"
                        class="bg-red-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-red-700 transition">
                        Simulate
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">*Enter a number between 30% and 50%</p>
            </div>

            <!-- Credit Simulation Box -->
            <div id="simulationBox" class="hidden opacity-0 transition-opacity duration-500 ease-in-out bg-gray-50 rounded-lg shadow p-4 border border-gray-200">
                <h2 class="text-center text-lg font-bold mb-4 text-gray-800">CREDIT SIMULATION</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center">
                        <thead>
                            <tr class="bg-green-600 text-white">
                                <th class="p-2">Tenor (Years)</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-t">
                                <td class="font-medium py-1">Down Payment</td>
                                <td colspan="5" id="dpAmount">Rp0</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-medium py-1">Installments / Month</td>
                                <td>Rp23,504,404</td>
                                <td>Rp12,407,596</td>
                                <td>Rp8,718,386</td>
                                <td>Rp6,960,195</td>
                                <td>Rp6,013,016</td>
                            </tr>
                            <tr class="border-t bg-gray-50">
                                <td class="font-medium py-1">Admin Fee</td>
                                <td>Rp1,246,000</td>
                                <td>Rp1,296,000</td>
                                <td>Rp1,346,000</td>
                                <td>Rp1,396,000</td>
                                <td>Rp1,666,000</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-medium py-1">Insurance</td>
                                <td colspan="5">Rp11,336,400</td>
                            </tr>
                            <tr class="border-t bg-gray-50">
                                <td class="py-2 font-semibold text-gray-900 bg-gray-100">Total Payment</td>
                                <td>Rp168,746,804</td>
                                <td>Rp157,699,996</td>
                                <td>Rp154,060,786</td>
                                <td>Rp152,352,595</td>
                                <td>Rp151,675,416</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-4 mt-6">
                <button class="bg-gray-300 text-black px-6 py-2 rounded-full">CANCEL</button>
                <button class="bg-black text-white px-6 py-2 rounded-full">CONFIRM</button>
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="bg-gray-50 text-center p-10">
        <h3 class="text-md font-semibold text-gray-800 mt-20">**Notes</h3>
        <ul class="text-xs text-gray-800 mt-2 space-y-2 list-inside list-disc">
            <li>The displayed price is the OTR Jakarta price for the first car ownership, and may change at any time without prior notice.</li>
            <li>Changes in color, materials, and features may occur at any time without prior notification.</li>
            <li>Specifications, features, and materials may differ from the actual vehicle being sold.</li>
        </ul>
    </div>
</div>

<!-- Script for carousel -->
<script>
    const carouselInner = document.querySelector('.carousel-inner');
    const totalSlides = carouselInner.children.length;
    let currentIndex = 0;

    function slideTo(index) {
        carouselInner.style.transform = `translateX(-${index * 100}%)`;
    }

    function autoSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        slideTo(currentIndex);
    }

    setInterval(autoSlide, 4000);
</script>
@endsection