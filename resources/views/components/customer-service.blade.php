<div x-data="{ openChat: false }" class="relative">
    <button
        class="flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition"
        @click="openChat = true"
        aria-label="Customer Service Chat"
    >
        <!-- WhatsApp Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 32 32" fill="currentColor">
            <path d="M16.003 2.667c-7.333 0-13.333 5.92-13.333 13.2 0 2.32.653 4.48 1.787 6.373L2.667 29.333l7.28-1.893c1.84 1.013 3.933 1.547 6.053 1.547h.007c7.333 0 13.333-5.92 13.333-13.2s-6-13.2-13.337-13.2zm7.64 17.653c-.32.893-1.853 1.76-2.56 1.867-.693.107-1.547.16-2.493-.16-1.093-.36-2.48-.867-4.32-2.613-1.6-1.52-2.693-3.373-3-3.947-.307-.573-.72-1.494-.72-2.4 0-.893.467-1.32.64-1.493.173-.173.387-.2.52-.2.133 0 .267 0 .387.007.133.007.293-.047.453.36.173.427.587 1.453.64 1.56.053.107.08.24.013.387-.067.147-.1.24-.2.373-.1.133-.213.293-.307.387-.107.107-.22.227-.093.44.133.213.6.987 1.293 1.6.893.8 1.6 1.053 1.813 1.173.213.12.333.107.453-.067.12-.173.52-.6.667-.8.147-.2.293-.173.48-.107.2.067 1.267.6 1.48.707.213.107.36.16.413.253.053.093.053.96-.267 1.853z"/>
        </svg>
    </button>
    <!-- Chat Modal -->
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-show="openChat"
        x-cloak
    >
        <div class="bg-white rounded-lg p-6 w-[90%] sm:w-80 shadow-xl transform transition-transform duration-300 scale-95" x-transition>
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Let's Chat!</h2>
            <textarea
                placeholder="Type your message..."
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
            <div class="mt-4 flex justify-end space-x-2">
                <button
                    @click="openChat = false"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition"
                >
                    Cancel
                </button>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>