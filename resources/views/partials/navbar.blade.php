    <!-- NAVBAR -->
    <nav class="bg-white shadow-md px-10 py-4 flex justify-between items-center fixed top-0 left-0 w-full z-50">
        <!-- Logo dan Search -->
        <div class="flex items-center gap-6">
            <img src="/images/venuscars1.png" alt="Venus Cars Logo" class="h-10">
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search cars..." 
                    class="pl-10 pr-4 py-2 w-64 text-sm rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#bfae91] transition duration-300"
                />
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
            </div>
        </div>
    
        <!-- Navigasi -->
        <div class="flex items-center gap-8 text-gray-800 text-sm font-medium tracking-wide">
            <a href="{{ route('customer.home') }}" class="hover:text-[#5a4c36] transition">Home</a>
            <a href="{{ route('customer.shop') }}" class="hover:text-[#5a4c36] transition">Shop</a>
            <a href="{{ route('customer.about') }}" class="hover:text-[#5a4c36] transition">About</a>
            <a href="{{ route('customer.contact') }}" class="hover:text-[#5a4c36] transition">Contact</a>
    
            <a href="#" class="hover:text-[#5a4c36] transition">
                <i class="fas fa-user text-lg"></i>
            </a>
            <a href="#" class="hover:text-[#5a4c36] transition">
                <i class="fas fa-heart text-lg"></i>
            </a>
        </div>
    </nav>
    