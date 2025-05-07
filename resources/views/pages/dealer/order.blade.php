<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - Seller Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-50 flex flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center h-24">
            <img src="/images/venuscars1.png" alt="Venus Cars" class="h-16">
        </div>
        <nav class="mt-4">
            <a href="/dashboard-penjual" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 20v-6h4v6h5v-8h3L10 0 2 12h3v8z" />
                </svg>
                <span class="ml-3">Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100 font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0L12 13 4 7" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ml-3">Daftar Produk</span>
            </a>
            <a href="/daftar-pesanan" class="flex items-center px-6 py-2 text-gray-700 hover:bg-gray-100 font-bold">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z" />
                </svg>
                <span class="ml-3">Daftar Pesanan</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col bg-gray-50">

        <!-- Navbar -->
        <header class="p-6 flex justify-center items-center relative">
            <h1 class="text-2xl font-semibold">Seller Center</h1>
            <a href="#"
                class="absolute right-10 top-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                </svg>
                Logout
            </a>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-10 bg-gray-100">
            <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
                <h2 class="text-xl font-semibold mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z" />
                    </svg>
                    Daftar Pesanan
                </h2>
                <div class="border-b border-black mb-6"></div>

                <!-- Filter Buttons -->
                <div class="flex space-x-2 mb-4">
                    <a href="/daftar-pesanan" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Semua</a>
                    <a href="/konfirmasi" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Konfirmasi</a>
                    <a href="/diproses" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Diproses</a>
                    <a href="/dikirim" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Dikirim</a>
                    <a href="/selesai" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Selesai</a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-center">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Produk</th>
                                <th class="px-4 py-2 border">Total Pesanan</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="px-4 py-2 border">1</td>
                                <td class="flex items-center justify-center py-2">
                                    <img src="/images/hondahrvwhite.png" alt="Honda Mobilio" class="h-16 w-30 object-cover mr-2">
                                    Honda HR-V
                                </td>
                                <td class="px-4 py-2 border">Rp 243.300.000</td>
                                <td class="px-4 py-2 border">Diproses</td>
                                <td class="px-4 py-2 border">
                                    <button class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded">Print</button>
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2 border">2</td>
                                <td class="flex items-center justify-center py-2">
                                    <img src="/images/civicwhite.png" alt="New Honda City" class="h-16 w-30 object-cover mr-2">
                                    Civic Type R
                                </td>
                                <td class="px-4 py-2 border">Rp 1.150.000.000</td>
                                <td class="px-4 py-2 border">Konfirmasi</td>
                                <td class="px-4 py-2 border">
                                    <button class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded">Print</button>
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2 border">2</td>
                                <td class="flex items-center justify-center py-2">
                                    <img src="/images/hondamobiliowhite.png" alt="New Honda City" class="h-16 w-30 object-cover mr-2">
                                    Honda Mobilio
                                </td>
                                <td class="px-4 py-2 border">Rp 150.000.000</td>
                                <td class="px-4 py-2 border">Dikirim</td>
                                <td class="px-4 py-2 border">
                                    <button class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded">Print</button>
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="px-4 py-2 border">2</td>
                                <td class="flex items-center justify-center py-2">
                                    <img src="/images/newhondacityblack.png" alt="New Honda City" class="h-16 w-30 object-cover mr-2">
                                    New Honda City
                                </td>
                                <td class="px-4 py-2 border">Rp 402.000.000</td>
                                <td class="px-4 py-2 border">Selesai</td>
                                <td class="px-4 py-2 border">
                                    <button class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded">Print</button>
                                </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>


    </div>

    </div>

</body>

</html>