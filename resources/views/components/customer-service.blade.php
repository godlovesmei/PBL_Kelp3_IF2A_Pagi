<div x-data="{ openChat: false, chatMessage: '' }" class="relative">
    <!-- WhatsApp Floating Button -->
    <button
        class="w-12 h-12 bg-[#25D366] text-white rounded-full shadow-lg hover:bg-[#1DA851] transition duration-300 flex items-center justify-center"
        @click="openChat = true"
        aria-label="Open WhatsApp Chat"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 448 512" fill="currentColor">
            <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32C101.5 32 2 131.6 2 254c0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222c0-59.3-25.2-115-67.1-157zM223.9 438.7c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7C49.1 322.8 39.4 288.9 39.4 254c0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zM325.1 300.5c-5.5-2.8-32.8-16.2-37.9-18c-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
        </svg>
    </button>

    <!-- Chat Popup -->
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[999]"
        x-show="openChat"
        x-cloak
    >
        <div
            class="bg-white rounded-lg p-6 w-[90%] sm:w-80 shadow-xl transform transition-transform duration-300 scale-95"
            x-transition
        >
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Chat with Us</h2>
            <textarea
                x-model="chatMessage"
                placeholder="Type your message..."
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                rows="3"
            ></textarea>
            <div class="mt-4 flex justify-end space-x-2">
                <button
                    @click="openChat = false"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition"
                >
                    Cancel
                </button>
                <a
                    :href="'https://wa.me/6281378535706?text=' + encodeURIComponent(chatMessage)"
                    target="_blank"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"
                >
                    Send
                </a>
            </div>
        </div>
    </div>
</div>
