<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venus Cars | HIstory Transaction</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f2f2f2] font-sans">
    <!-- NAVBAR -->
    <nav class="bg-white shadow-md px-10 py-4 flex justify-between items-center sticky top-0 z-50">
        <!-- Logo dan Search -->
        <div class="flex items-center gap-6">
            <img src="/images/venuscars1.png" alt="Venus Cars Logo" class="h-10">
            <div class="relative">
                <input
                    type="text"
                    placeholder="Search cars..."
                    class="pl-10 pr-4 py-2 w-64 text-sm rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#bfae91] transition duration-300" />
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
            </div>
        </div>

        <!-- Navigasi -->
        <div class="flex items-center gap-8 text-gray-800 text-sm font-medium tracking-wide">
            <a href="/login" class="hover:text-[#5a4c36] transition">Home</a>
            <a href="#" class="hover:text-[#5a4c36] transition">Shop</a>
            <a href="#" class="hover:text-[#5a4c36] transition">About</a>
            <a href="#" class="hover:text-[#5a4c36] transition">Contact</a>

            <a href="#" class="hover:text-[#5a4c36] transition">
                <i class="fas fa-user text-lg"></i>
            </a>
            <a href="#" class="hover:text-[#5a4c36] transition">
                <i class="fas fa-heart text-lg"></i>
            </a>
        </div>
    </nav>

    <!-- SIDEBAR + MAIN CONTENT -->
    <div class="max-w-7xl mx-auto flex mt-10">
        <!-- SIDEBAR -->
        <aside class="w-58 bg-[#bcbcbc] rounded-xl p-10 text-center">
            <div class="mb-4">
                <i class="fas fa-user-circle text-6xl text-black mb-4"></i>
            </div>
            <nav class="space-y-4 text-sm text-black font-bold">
                <a href="#" class="block hover:underline">DASHBOARD</a>
                <a href="#" class="block hover:underline">TRANSAKSI</a>
                <a href="#" class="block hover:underline">EDIT PROFIL</a>
            </nav>
            <div class="mt-10 pt-4 border-t border-gray-400">
                <a href="#" class="text-red-600 font-bold flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 px-10">
            <h2 class="text-xl font-bold mb-6">TRANSACTION HISTORY</h2>

            <div class="overflow-x-auto">
                <table class="w-full border border-black text-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="border border-black px-4 py-2">Nomor Transaksi</th>
                            <th class="border border-black px-4 py-2">Nama Mobil</th>
                            <th class="border border-black px-4 py-2">Harga</th>
                            <th class="border border-black px-4 py-2">Tanggal</th>
                            <th class="border border-black px-4 py-2">Status</th>
                            <th class="border border-black px-4 py-2">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Kosong dulu -->
                        <tr>
                            <td class="border border-black px-4 py-2 text-center" colspan="6">Belum ada transaksi.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#000000] text-white py-10 px-8 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Info Brand -->
            <div>
                <h3 class="text-2xl font-bold font-serif mb-2">Venus Cars</h3>
                <p class="text-sm text-gray-300">
                    Menghadirkan mobil pilihan terbaik untuk setiap perjalanan hidup Anda.
                    Karena setiap roda punya cerita.
                </p>
                <p class="text-xs text-gray-400 mt-4">© 2025 Venus Cars. Drive Your Destiny.</p>
            </div>

            <!-- Link Navigasi -->
            <div>
                <h4 class="text-lg font-semibold mb-2">Menu</h4>
                <ul class="space-y-1 text-gray-300">
                    <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="#" class="hover:underline">Layanan</a></li>
                    <li><a href="#" class="hover:underline">Showroom</a></li>
                </ul>
            </div>

            <!-- Kontak & Sosmed -->
            <div>
                <h4 class="text-lg font-semibold mb-2">Hubungi Kami</h4>
                <p class="text-sm text-gray-300 mb-2">
                    Tim kami siap membantu Anda:<br>
                    <strong>0-800-14-46632</strong>
                </p>
                <div class="flex space-x-4 mt-3 text-xl">
                    <a href="#" class="hover:text-pink-400"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-sky-400"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-blue-600"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-red-500"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
