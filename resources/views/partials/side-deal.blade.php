<aside class="fixed top-16 left-0 w-64 h-screen bg-gray-800 text-white shadow-lg lg:block hidden" id="sidebar">
    <div class="flex items-center justify-center h-24 border-b border-gray-700">
        <img src="{{ asset('images/venuscars1.png') }}" alt="Venus Cars Logo" class="h-16">
    </div>
    <nav class="mt-4 space-y-2 px-4">
        <a href="{{ route('dealer.dashboard') }}"
           class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->routeIs('dealer.dashboard') ? 'bg-gray-700 font-semibold' : '' }}">
            <i class="fas fa-home w-5"></i>
            <span class="ml-3">Dashboard</span>
        </a>
        <a href="{{ route('dealer.mobil') }}"
           class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->routeIs('dealer.mobil') ? 'bg-gray-700 font-semibold' : '' }}">
            <i class="fas fa-car w-5"></i>
            <span class="ml-3">Daftar Mobil</span>
        </a>
        <a href="{{ route('dealer.mobil.create') }}"
           class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->routeIs('dealer.mobil.create') ? 'bg-gray-700 font-semibold' : '' }}">
            <i class="fas fa-plus-circle w-5"></i>
            <span class="ml-3">Tambah Mobil</span>
        </a>
        <a href="/daftar-produk"
           class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->is('daftar-produk') ? 'bg-gray-700 font-semibold' : '' }}">
            <i class="fas fa-box w-5"></i>
            <span class="ml-3">Daftar Produk</span>
        </a>
        <a href="/daftar-pesanan"
           class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->is('daftar-pesanan') ? 'bg-gray-700 font-semibold' : '' }}">
            <i class="fas fa-list-alt w-5"></i>
            <span class="ml-3">Daftar Pesanan</span>
        </a>
    </nav>
</aside>