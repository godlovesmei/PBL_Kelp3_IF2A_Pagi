<!-- Navbar -->
<header class="p-6 flex justify-center items-center relative">
    <h1 class="text-2xl font-semibold">Seller Center</h1>

    <!-- Tombol Settings (link ke halaman profile penjual) -->
    <a href="{{ route('dealer.profile') }}"
        class="absolute right-36 top-6 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.983 13.931a2.003 2.003 0 100-4.006 2.003 2.003 0 000 4.006zM19.435 12.478c.03-.316.045-.638.045-.965s-.015-.649-.045-.965l2.122-1.654a.5.5 0 00.11-.638l-2-3.464a.5.5 0 00-.605-.22l-2.497 1a7.99 7.99 0 00-1.671-.965l-.378-2.65A.5.5 0 0014 2h-4a.5.5 0 00-.497.435l-.378 2.65a7.99 7.99 0 00-1.671.965l-2.497-1a.5.5 0 00-.605.22l-2 3.464a.5.5 0 00.11.638l2.122 1.654c-.03.316-.045.638-.045.965s.015.649.045.965L2.453 14.13a.5.5 0 00-.11.638l2 3.464a.5.5 0 00.605.22l2.497-1c.52.39 1.08.718 1.671.965l.378 2.65A.5.5 0 0010 22h4a.5.5 0 00.497-.435l.378-2.65a7.99 7.99 0 001.671-.965l2.497 1a.5.5 0 00.605-.22l2-3.464a.5.5 0 00-.11-.638l-2.122-1.654z" />
        </svg>
        Settings
    </a>
</header>