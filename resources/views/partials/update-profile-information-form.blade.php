<!-- Tombol dan Dropdown -->
<div class="fixed top-4 right-4 z-50" x-data="{ open: false }">
  <!-- Tombol titik tiga -->
  <button @click="open = !open"
          class="p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none"
          aria-expanded="false" aria-label="Toggle menu">
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
    </svg>
  </button>

  <!-- Dropdown menempel di bawah tombol -->
  <div x-show="open"
       @click.outside="open = false"
       x-transition
       class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
    <a href="{{ route('pages.home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
    <a href="{{ route('pages.shop') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Shop</a>
    <a href="{{ route('pages.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About</a>
    <a href="{{ route('pages.contact') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact</a>
    <a href="{{ route('pages.wishlist') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">
  <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 20 20">
    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
  </svg>
</a>
  </div>
</div>

<section>
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
    <form method="post" action="{{ route('pages.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" :value="('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" :value="('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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
        <div>
            <x-input-label for="phone" :value="('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>
        <div>
            <x-input-label for="address" :value="('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <x-primary-button class="w-full sm:w-auto">{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:mt-0">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>