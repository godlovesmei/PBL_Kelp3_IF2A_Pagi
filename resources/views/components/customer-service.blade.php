<div x-data="{ openChat: false, chatMessage: '' }" class="fixed bottom-5 right-5 z-50">
    <!-- WhatsApp Floating Button -->
    <button
        class="w-10 h-10 sm:w-12 sm:h-12 bg-[#257f6f] text-white rounded-full shadow-lg hover:bg-[#22544c] transition duration-300 flex items-center justify-center"
        @click="openChat = true"
        aria-label="Open WhatsApp Chat"
    >
        <!-- Clean WhatsApp SVG icon -->
        <svg viewBox="0 0 448 512" width="22" height="22" fill="currentColor" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
            <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
        </svg>
    </button>

    <!-- Chat Popup -->
    <div
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[999]"
        x-show="openChat"
        x-cloak
    >
        <div
            class="bg-white w-[92%] max-w-xs rounded-xl p-4 shadow-xl relative transform transition-all duration-300 scale-95"
            x-transition
        >
            <h2 class="text-base font-semibold mb-2 text-gray-800">Chat with Us</h2>
            <textarea
                x-model="chatMessage"
                placeholder="Type your message..."
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 resize-none text-sm"
                rows="3"
            ></textarea>

            <div class="mt-3 flex justify-end gap-2 text-sm">
                <button
                    @click="openChat = false"
                    class="px-3 py-1.5 bg-gray-200 rounded-md hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <a
                    :href="'https://wa.me/6281378535706?text=' + encodeURIComponent(chatMessage)"
                    target="_blank"
                    class="px-4 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition"
                >
                    Send
                </a>
            </div>
        </div>
    </div>
</div>
