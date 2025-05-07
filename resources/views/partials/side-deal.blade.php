<!-- Sidebar -->
<aside class="w-64 bg-gray-50 flex flex-col">
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-24">
        <img src="/images/venuscars1.png" alt="Venus Cars" class="h-16">
    </div>

    <!-- Navigasi Menu -->
    <nav class="mt-4">
        
        <!-- Link ke Dashboard -->
        <a href="/dashboard-penjual" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 20v-6h4v6h5v-8h3L10 0 2 12h3v8z" />
            </svg>
            <span class="ml-3">Dashboard</span>
        </a>

        <!-- Link ke Daftar Produk -->
        <a href="{{ route('dealer.mobil.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100 font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0L12 13 4 7" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="ml-3">Daftar Produk</span>
        </a>

        <!-- Link ke Daftar Pesanan -->
        <a href="/daftar-pesanan" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100 font-bold">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z" />
            </svg>
            <span class="ml-3">Daftar Pesanan</span>
        </a>

    </nav>
</aside>
