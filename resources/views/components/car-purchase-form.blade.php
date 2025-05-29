@props(['car', 'carPrice'])

@if(session('success'))
<div x-data="{ show: true }" x-show="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md text-center shadow-lg">
        <p class="mb-4 text-lg font-semibold">{{ session('success') }}</p>
        <button 
            @click="show = false; window.location.href='{{ session('redirectTo') }}'" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            OK
        </button>
    </div>
</div>
@endif

<div class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="bg-gray-100 rounded-xl p-6 w-full max-w-xl shadow-lg mt-10 mx-2">
        <h2 class="text-center text-xl font-semibold mb-6">Submit Purchase Request</h2>

        <form action="{{ route('purchase.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Full Name -->
            <div>
                <x-input-label for="name" :value="('Name')" />
                <x-text-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="Enter your full name" 
                    value="{{ old('name') }}"
                    required 
                    autofocus
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="('Address')" />
                <x-textarea id="address" name="address" placeholder="Enter your full address" required class="w-full" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="mt-4">
                <x-input-label for="phone" :value="('Phone')" />
                <x-text-input 
                    id="phone" 
                    name="phone" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="Enter Phone Number" 
                    value="{{ old('phone') }}" 
                    required
                />

                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="('Email')" />
                <x-text-input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    placeholder="Enter email" 
                    value="{{ old('email') }}"
                    required
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Upload Documents -->
            <div class="mt-6">
                <div class="flex items-center mb-4">
                    <!-- SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 
                            1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 
                            1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 
                            6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 
                            0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p class="font-bold text-gray-800">Upload Supporting Documents</p>
                </div>

                <div>
                    <x-input-label for="ktp" :value="('ID Card (KTP)')" />
                    <input 
                        id="ktp" 
                        name="ktp" 
                        type="file" 
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-1 block w-full text-sm border border-gray-300 rounded-md px-3 py-2" 
                        required
                    />
                    <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="npwp" :value="('Tax ID (NPWP)')" />
                    <input 
                        id="npwp" 
                        name="npwp" 
                        type="file" 
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-1 block w-full text-sm border border-gray-300 rounded-md px-3 py-2"
                    />
                    <x-input-error :messages="$errors->get('npwp')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="salary_slip" :value="('Salary Slip')" />
                    <input 
                        id="salary_slip" 
                        name="salary_slip" 
                        type="file" 
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-1 block w-full text-sm border border-gray-300 rounded-md px-3 py-2"
                    />
                    <x-input-error :messages="$errors->get('salary_slip')" class="mt-2" />
                </div>
            </div>

            @if(isset($car))
                <input type="hidden" name="car_id" value="{{ $car->id }}">
            @endif

            <!-- Payment Method -->
            <div class="mt-6" x-data="{ payment: '{{ old('payment_method') }}' }">
                <x-input-label for="payment_method" :value="('Payment Method')" />

                <div class="relative">
                    <select 
                        id="payment_method" 
                        name="payment_method" 
                        x-model="payment"
                        class="appearance-none mt-1 block w-full text-sm border border-gray-300 rounded-md px-10 py-2 pr-10"
                        required
                    >
                        <option value="" disabled :selected="payment === ''">Select Payment Method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="cash">Cash</option>
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <template x-if="payment === 'credit_card'">
                            <!-- Credit Card Icon -->
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
                            </svg>
                        </template>
                        <template x-if="payment === 'cash'">
                            <!-- Cash Icon -->
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                            </svg>
                        </template>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
            </div>

            <x-down-payment-input :carPrice="$carPrice" />
            <x-credit-simulation :carPrice="$carPrice" />

            <!-- Buttons -->
            <div class="flex justify-center gap-4 mt-6">
                <x-button type="button" color="gray" onclick="window.history.back()">
                    CANCEL
                </x-button>

                @auth
                    <x-button type="submit" color="black">
                        CONFIRM
                    </x-button>
                @else
                    <x-button 
                        type="button" 
                        color="black" 
                        onclick="window.location='{{ route('login') }}'"
                    >
                        CONFIRM
                    </x-button>
                @endauth
            </div>
        </form>
    </div>
</div>
