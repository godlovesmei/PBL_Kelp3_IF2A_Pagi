@props([
    'notifications' => auth()->user()?->notifications()->latest()->limit(20)->get() ?? collect(),
    'unreadCount' => auth()->user()?->unreadNotifications->count() ?? 0,
    'mobile' => false
])

<div
    x-data="{ openNotif: false }"
    @mouseenter="if (!{{ $mobile ? 'true' : 'false' }}) openNotif = true"
    @mouseleave="if (!{{ $mobile ? 'true' : 'false' }}) openNotif = false"
    class="relative"
>
    <button
        @click="openNotif = !openNotif"
        class="flex items-center justify-center w-10 h-10 rounded relative hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition focus:outline-none focus:ring-2 focus:ring-blue-300"
        :aria-expanded="openNotif"
        aria-label="Toggle notifications"
        type="button"
        @keydown.escape="openNotif = false"
    >
        <svg class="w-6 h-5 text-[#414846] dark:text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.133 12.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z" />
        </svg>
        @auth
            @if($unreadCount > 0)
                <span class="absolute top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none">
                    {{ $unreadCount }}
                </span>
            @endif
        @endauth
    </button>

    <div
        x-show="openNotif"
        x-transition
        @click.outside="openNotif = false"
        class="
            absolute
            {{ $mobile ? 'left-0 right-0 w-full max-w-full mt-2' : 'right-0 mt-2 w-[24rem] max-w-md' }}
            bg-white dark:bg-gray-800 shadow-lg rounded-lg z-50
        "
        style="display: none;"
    >
        @auth
            <div class="p-3 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-100 text-base">
                Notifications
            </div>
            <div class="max-h-64 overflow-y-auto">
                @forelse($notifications as $notification)
                    <a
                        href="{{ route('notifications.readAndRedirect', $notification->id) }}"
                        class="block px-4 py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-[#d2e1f0] dark:hover:bg-[#374846]
                        {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/20 font-bold' : '' }}"
                    >
                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate">
                            {{ $notification->data['message'] ?? 'No message' }}
                        </p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs truncate">
                            Car: {{ $notification->data['car_model'] ?? '-' }}
                        </p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                        @if(is_null($notification->read_at))
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs text-white bg-blue-500 rounded">New</span>
                        @endif
                    </a>
                @empty
                    <p class="p-4 text-gray-500 dark:text-gray-400 text-center text-xs">No notifications.</p>
                @endforelse
            </div>
            <div class="px-4 py-2 text-right border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-b-lg">
                <a href="{{ route('user.orders.index') }}" class="text-sm text-blue-600 dark:text-teal-400 hover:underline font-medium">
                    View My Orders
                </a>
            </div>
        @else
            <div class="p-4 flex flex-col items-center space-y-2 text-center text-gray-600 dark:text-gray-300">
                <img src="{{ asset('images/smile.png') }}" alt="Smile" class="w-12 h-12 mx-auto">
                <p class="text-sm">Log in to view notifications</p>
                <a href="{{ route('login') }}" class="text-blue-600 dark:text-teal-400 hover:underline font-medium text-sm">
                    Log in
                </a>
            </div>
        @endauth
    </div>
</div>
