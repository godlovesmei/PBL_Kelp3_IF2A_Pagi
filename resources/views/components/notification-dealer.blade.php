@props(['notifications' => auth()->user()?->unreadNotifications ?? collect()])

<div x-data="{ notifOpen: false }" @mouseenter="notifOpen = true" @mouseleave="notifOpen = false" class="relative">
  <!-- Bell Icon -->
  <button
    class="relative p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none transition"
    aria-label="Notifications">
    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 17h5l-1.405-1.405C18.21 14.79 18 13.918 18 13V9a6 6 0 00-12 0v4c0 .918-.21 1.79-.595 2.595L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
    </svg>
    @if($notifications->count())
      <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2">
        {{ $notifications->count() }}
      </span>
    @endif
  </button>

  <!-- Dropdown -->
  <div
    x-cloak
    x-show="notifOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-30"
  >
    <div class="py-2 text-sm text-gray-700 dark:text-gray-300">
      @if($notifications->count())
        <form method="POST" action="{{ route('notifications.read.all') }}" class="px-4 mb-1">
          @csrf
          @method('PATCH')
          <button type="submit"
                  class="text-sm text-blue-600 hover:underline dark:text-blue-400">
            Mark all as read
          </button>
        </form>
      @endif

      @forelse($notifications as $notification)
        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
          @csrf
          @method('PATCH')
          <input type="hidden" name="redirect" value="{{ $notification->data['url'] ?? '#' }}">
          <button type="submit"
            class="block w-full text-left px-4 py-2 transition
              {{ is_null($notification->read_at)
                  ? 'bg-gray-100 dark:bg-gray-700 font-semibold'
                  : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            {{ $notification->data['message'] ?? 'New Notification' }}
          </button>
        </form>
      @empty
        <div class="px-4 py-2 text-gray-500 dark:text-gray-400">No new notifications.</div>
      @endforelse
    </div>
  </div>
</div>
