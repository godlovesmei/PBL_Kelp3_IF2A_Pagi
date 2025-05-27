<div class="relative hidden lg:block w-72">
  <form action="{{ route('pages.shop') }}" method="GET" class="relative">
    <!-- Search Icon -->
    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
      <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="m20.267 19.207-4.818-4.818A6.97 6.97 0 0 0 17 10a7 7 0 1 0-7 7 6.97 6.97 0 0 0 4.389-1.55l4.818 4.817a.75.75 0 0 0 1.06 0 .75.75 0 0 0 0-1.06M4.5 10c0-3.033 2.467-5.5 5.5-5.5s5.5 2.467 5.5 5.5-2.467 5.5-5.5 5.5-5.5-2.467-5.5-5.5"/>
      </svg>
    </div>

    <!-- Input -->
    <input 
      id="searchInput"
      type="text" 
      name="search"
      placeholder="Search cars..." 
      class="pl-10 pr-10 py-2 w-full text-sm rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#bfae91] dark:focus:ring-gray-600 transition duration-300"
      autocomplete="off"
      oninput="toggleClearBtn()"
    >

    <!-- Clear Button -->
    <button 
      type="button" 
      id="clearBtn"
      class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-white"
      onclick="document.getElementById('searchInput').value=''; this.classList.add('hidden');"
      style="display: none;"
    >
      <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.243 11.182a.75.75 0 1 1-1.06 1.06L8 9.062l-3.182 3.182a.75.75 0 0 1-1.06 0 .75.75 0 0 1 0-1.06L6.938 8 3.757 4.818a.75.75 0 1 1 1.06-1.06L8 6.938l3.182-3.182a.75.75 0 1 1 1.06 1.06L9.062 8z"/>
      </svg>
    </button>
  </form>
</div>

<script>
  function toggleClearBtn() {
    const input = document.getElementById('searchInput');
    const btn = document.getElementById('clearBtn');
    btn.style.display = input.value ? 'block' : 'none';
  }
</script>
