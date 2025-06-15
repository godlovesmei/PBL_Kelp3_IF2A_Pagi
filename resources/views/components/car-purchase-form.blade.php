@props(['car', 'carPrice'])

@if(session('success'))
<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 flex items-center justify-center bg-black/70 z-[60]"
    aria-modal="true"
    role="dialog"
    x-cloak
>
    <div
        @click.away="show=false"
        class="relative bg-gradient-to-br from-white via-gray-50 to-green-50 rounded-2xl shadow-2xl p-7 md:p-8 w-full max-w-sm md:max-w-md text-center border border-green-200"
    >
        <!-- Close Button (Top Right) -->
        <button
            @click="show = false; @if(session('redirectTo')) window.location.href='{{ session('redirectTo') }}' @endif"
            class="absolute top-3 right-3 p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-400 hover:text-gray-700 transition"
            aria-label="Close"
        >
            <i class="fas fa-times text-base"></i>
        </button>

        <!-- Success Animation Circle -->
        <div class="flex justify-center mb-5">
            <div class="relative flex items-center justify-center h-14 w-14">
                <span class="absolute inline-flex h-full w-full rounded-full bg-green-100 animate-ping opacity-60"></span>
                <svg class="w-14 h-14 text-green-500 drop-shadow-lg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-opacity="0.15" stroke-width="2.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 13.5l3.5 3.5L17 9" />
                </svg>
            </div>
        </div>
        <h2 class="text-xl md:text-2xl font-extrabold text-green-700 mb-2 tracking-tight">Order Submitted!</h2>
        <p class="text-gray-700 text-sm md:text-base mb-4 leading-relaxed">
            Your order has been received and will be processed within <span class="font-semibold text-green-700">3–7 business days</span>.
            We will contact you soon for the next steps.
        </p>
        <div class="mb-6 text-gray-500 text-xs md:text-sm">
            Need help? <a  :href="'https://wa.me/6281378535706'"
                    target="_blank" class="text-indigo-600 font-semibold hover:underline">Contact Support</a>
        </div>
        <button
            @click="show = false; @if(session('redirectTo')) window.location.href='{{ session('redirectTo') }}' @endif"
            class="w-28 py-2 rounded-full bg-gradient-to-tr from-green-500 to-green-400 hover:from-green-600 hover:to-green-500 text-white font-bold text-base shadow-lg transition-all duration-200 focus:outline-none"
        >
            OK
        </button>
    </div>
</div>
@endif

<div class="flex justify-center items-start min-h-screen bg-gray-50 py-10 px-4">
    <div class="bg-gray-100 rounded-2xl p-8 w-full max-w-3xl shadow-lg">
        <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Vehicle Purchase Request</h2>

<p class="text-center text-gray-600 mb-6 font-light">
    Please fill out the form below to submit your vehicle purchase request.<br>
    Ensure all information is accurate to avoid delays in processing.
</p>


        <form action="{{ route('purchase.submit') }}" method="POST" enctype="multipart/form-data"
              x-data="creditForm({{ $carPrice }})"
              x-init="init()">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="name" value="Full Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="e.g. John Doe" value="{{ old('name') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="phone" value="Phone Number" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" placeholder="0812xxxxxxx" value="{{ old('phone') }}" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="email@example.com" value="{{ old('email') }}" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="payment_method" value="Payment Method" />
                    <select
                        id="payment_method"
                        name="payment_method"
                        x-model="paymentMethod"
                        class="appearance-none mt-1 block w-full border-gray-300 rounded-md px-3 py-2 text-sm"
                        required
                    >
                        <option value="" disabled>Select Method</option>
                        <option value="credit">Credit</option>
                        <option value="cash">Cash</option>
                    </select>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="address" value="Full Address" />
                    <x-textarea id="address" name="address" class="w-full" placeholder="Enter your full address" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="md:col-span-2">
                    <div class="font-semibold text-gray-800 mb-3">Upload Supporting Documents</div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="ktp" value="ID Card" />
                            <input id="ktp" name="ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full border text-sm border-gray-300 p-2 rounded" />
                            <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="npwp" value="Tax ID" />
                            <input id="npwp" name="npwp" type="file" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full border text-sm border-gray-300 p-2 rounded" />
                            <x-input-error :messages="$errors->get('npwp')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="salary_slip" value="Salary Slip" />
                            <input id="salary_slip" name="salary_slip" type="file" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full border text-sm border-gray-300 p-2 rounded" />
                            <x-input-error :messages="$errors->get('salary_slip')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            @if($car)
                <input type="hidden" name="car_id" value="{{ $car->id }}">
            @endif

            {{-- Credit Simulation Section --}}
            <x-credit-simulation :carPrice="$carPrice" />
            <br>
                    @if($car)
            <div class="text-center mb-6">
                <p class="text-lg text-gray-700 font-medium">
                    <strong>{{ $car->name }}</strong> - Total Price:
                    <span class="text-green-600 font-semibold">Rp {{ number_format($carPrice, 0, ',', '.') }}</span>
                </p>
            </div>
        @endif

            <div class="flex justify-center gap-4 mt-8">
                <x-button type="button" color="gray" onclick="window.history.back()">
                    CANCEL
                </x-button>
                @auth
                    <x-button type="submit" color="black">
                        SUBMIT
                    </x-button>
                @else
                    <x-button
                        type="button"
                        color="black"
                        onclick="window.location='{{ route('login') }}'"
                    >
                        SUBMIT
                    </x-button>
                @endauth
            </div>
        </form>
    </div>
</div>
