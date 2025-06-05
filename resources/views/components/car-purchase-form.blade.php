@props(['car', 'carPrice'])

@if(session('success'))
<div
    x-data="{ show: true }"
    x-show="show"
    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
>
    <div class="bg-white rounded-2xl p-8 max-w-lg w-full text-center shadow-2xl">
        <div class="flex justify-center mb-4">
            <svg class="w-14 h-14 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Order Submitted Successfully!</h2>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            Thank you for trusting us with your car purchase.<br>
            Your order will be processed within <strong>3–7 business days</strong>. We will contact you shortly for further details.<br><br>
            If you need assistance, feel free to reach out using the contact below.
        </p>
        <button
            @click="show = false; @if(session('redirectTo')) window.location.href='{{ session('redirectTo') }}' @endif"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-full transition duration-200 shadow-md"
        >
            OK
        </button>
    </div>
</div>
@endif

<div class="flex justify-center items-start min-h-screen bg-gray-50 py-10 px-4">
    <div class="bg-white rounded-2xl p-8 w-full max-w-3xl shadow-lg">
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
                            <input id="ktp" name="ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm border-gray-300 rounded-md py-2 px-3" required />
                            <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="npwp" value="Tax ID" />
                            <input id="npwp" name="npwp" type="file" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm border-gray-300 rounded-md py-2 px-3" />
                            <x-input-error :messages="$errors->get('npwp')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="salary_slip" value="Salary Slip" />
                            <input id="salary_slip" name="salary_slip" type="file" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm border-gray-300 rounded-md py-2 px-3" />
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
