<!-- NAVBAR -->
<nav class="bg-[#f2f2f2] shadow-md px-10 py-5 flex justify-between items-center fixed top-0 left-0 w-full z-50">    <!-- Logo dan Search -->
    <div class="flex items-center gap-6">
        <svg class="h-10" width="110" height="110" viewBox="0 0 200 200" fill="black" xmlns="http://www.w3.org/2000/svg">
            <text x="-100" y="195" font-family="Georgia, serif" font-size="255" font-weight="bold" letter-spacing="-20">V</text>
            <text x="40" y="170" font-family="Georgia, serif" font-size="225" font-weight="bold" letter-spacing="-20">C</text>
        </svg>

        <div class="relative">
            <input 
                type="text" 
                placeholder="Search cars..." 
                class="pl-10 pr-4 py-2 w-64 text-sm rounded-full border focus:outline-none focus:ring-2 focus:ring-[#bfae91] transition duration-300"
                style="border-color: #f2f2f2;"
            />
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
        </div>
    </div>

    <!-- Navigasi -->
    <div class="flex items-center gap-8 text-gray-800 text-sm font-medium tracking-wide">
        <a href="{{ route('customer.home') }}" class="hover:text-[#5a4c36] transition">Home</a>
        
        <!-- Dropdown Shop -->
        <div class="relative group">
            <a href="{{ route('customer.shop') }}" class="hover:text-[#5a4c36] transition">Shop</a>
            <!-- Dropdown Menu -->
            <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-md w-48 mt-2 border border-gray-200">
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Mobil Sedan</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Mobil SUV</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Mobil Hatchback</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Mobil Sport</a>
            </div>
        </div>

        <a href="{{ route('customer.about') }}" class="hover:text-[#5a4c36] transition">About</a>
        <a href="{{ route('customer.contact') }}" class="hover:text-[#5a4c36] transition">Contact</a>

        <a href="{{ route('customer.profile') }}" 
   class="hover:text-[#5a4c36] transition relative group">
    <i class="fas fa-user text-sm"></i>
    <span class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-300">
        Profile
    </span>
</a>

<!-- Ikon Favorit -->
<a href="{{ route('customer.wishlist') }}" class="hover:text-[#5a4c36] transition relative group">
    <i class="fas fa-heart text-sm"></i>
    <span class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-300">
        Wishlist
    </span>
</a>
    </div>
</nav>

    