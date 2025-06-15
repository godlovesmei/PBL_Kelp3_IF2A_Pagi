<div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
  <button @click="open = !open" class="relative focus:outline-none text-gray-700 dark:text-gray-300 hover:text-[#8a7f6f] transition">
    <!-- Bell Icon -->
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      <path d="M17.133 12.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z"/>
    </svg>
    @auth
      @php $unread = auth()->user()->unreadNotifications->count(); @endphp
      @if($unread > 0)
        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center">
          {{ $unread }}
        </span>
      @endif
    @endauth
  </button>

  <!-- Dropdown -->
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-1"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-1"
    class="absolute right-0 mt-2 w-80 max-w-xs bg-white dark:bg-gray-800 shadow-lg rounded-lg z-50 pointer-events-auto"
    style="display: none;"
  >
    @auth
      <div class="p-3 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-100">
        Notifikasi
      </div>
      <div class="max-h-64 overflow-y-auto">
        @forelse(auth()->user()->unreadNotifications as $notification)
          <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $notification->data['message'] }}</p>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Mobil: {{ $notification->data['car_model'] }}</p>
            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
              @csrf
              @method('PATCH')
              <button type="submit" class="text-blue-600 dark:text-blue-400 text-xs mt-1 hover:underline">
                Tandai sudah dibaca
              </button>
            </form>
          </div>
        @empty
          <p class="p-4 text-gray-500 dark:text-gray-400 text-center text-sm">Tidak ada notifikasi baru.</p>
        @endforelse
      </div>
    @else
      <div class="p-4 flex flex-col items-center space-y-2 text-center text-gray-600 dark:text-gray-300">
        <img src="{{ asset('images/smile.png') }}" alt="Smile" class="w-16 h-16 mx-auto">
        <p>Login untuk melihat notifikasi</p>
        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
          Login sekarang
        </a>
      </div>
    @endauth
  </div>
</div>




