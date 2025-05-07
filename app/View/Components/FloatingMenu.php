<div class="fixed right-4 bottom-6 space-y-3 z-40" x-data="{ openChat: false }">
  <!-- Simulasi Harga -->
  <button class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition"
          @click="alert('Price Simulation feature coming soon!')">
      <!-- Ikon Simulasi Harga: Heroicons -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m-6 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
  </button>
  <div class="text-gray-700 text-xs text-center"></div>

  <!-- Download Brosur -->
  <a href="https://example.com/brochure.pdf" target="_blank"
     class="flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition">
      <!-- Ikon Download Brosur: Heroicons -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
  </a>
  <div class="text-gray-700 text-xs text-center"></div>

  <!-- Let's Chat -->
  <button class="flex items-center justify-center w-12 h-12 bg-red-500 text-white rounded-full shadow-lg hover:bg-red-600 transition"
          @click="openChat = true">
      <!-- Ikon Chat: Heroicons -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 4v-4H7a2 2 0 01-2-2v-8a2 2 0 012-2h2m8 0V6a4 4 0 10-8 0v2h8z" />
      </svg>
  </button>
  <div class="text-gray-700 text-xs text-center"></div>

  <!-- Chat Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="openChat" x-cloak>
      <div class="bg-white rounded-lg p-6 w-[90%] sm:w-80 shadow-xl transform transition-transform duration-300 scale-95" x-transition>
          <h2 class="text-lg font-semibold mb-4 text-gray-800">Let's Chat!</h2>
          <textarea placeholder="Type your message..."
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          <div class="mt-4 flex justify-end space-x-2">
              <button @click="openChat = false"
                      class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                  Cancel
              </button>
              <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                  Send
              </button>
          </div>
      </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/umd/heroicons.min.js"></script>
