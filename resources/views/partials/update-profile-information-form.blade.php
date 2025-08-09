<section class="max-w-2xl mx-auto mt-4 px-4">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('pages.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="'Name'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="'Phone'" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)"
                required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="'Address'" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)"
                required autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        @if ($dealer)
            <!-- Dealer Information Section -->
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">Dealer Information</h3>
                <div>
                    <x-input-label for="sosmed_link" :value="'Sosmed Link'" />
                    <x-text-input id="sosmed_link" name="sosmed_link" type="text" class="mt-1 block w-full"
                        :value="old('sosmed_link', $dealer?->sosmed_link)" autocomplete="url" />
                    <x-input-error class="mt-2" :messages="$errors->get('sosmed_link')" />
                </div>
                <div class="mt-4">
                    <x-input-label for="logo" :value="'Logo Dealer'" />
                    <input id="logo" name="logo" type="file"
                        class="mt-1 block w-full text-gray-700 dark:text-gray-200 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        accept="image/*" />
                    @if ($dealer->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $dealer->logo) }}" alt="Logo Dealer"
                                class="h-16 rounded shadow border dark:border-gray-700" />
                        </div>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                </div>
            </div>
        @endif

        <!-- Tombol Simpan -->
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <x-primary-button class="w-full sm:w-auto">{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:mt-0">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
