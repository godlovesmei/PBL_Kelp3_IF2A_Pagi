<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Main Layout -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="flex items-center justify-center h-24 border-b border-gray-700">
                <img src="/images/venuscars1.png" alt="Venus Cars Logo" class="h-16">
            </div>
            <nav class="mt-4 space-y-2 px-4">
                <a href="/dashboard-penjual" class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->is('dashboard-penjual') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="/daftar-produk" class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->is('daftar-produk') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span class="ml-3">Daftar Produk</span>
                </a>
                <a href="/daftar-pesanan" class="flex items-center py-2 px-3 rounded hover:bg-gray-700 {{ request()->is('daftar-pesanan') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-list-alt w-5"></i>
                    <span class="ml-3">Daftar Pesanan</span>
                </a>
            </nav>
        </aside>

        <!-- Content Section -->
        <div class="flex-1 flex flex-col">

            <!-- Navbar -->
            <header class="flex items-center justify-between bg-white px-6 py-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold">Seller Center</h1>
                <div class="relative">
                    <button id="settings-menu-button" class="flex items-center bg-gray-800 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-300">
                        <i class="fas fa-cog"></i>
                        <span class="ml-2">Settings</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="settings-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg">
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Pengaturan Profil
                        </a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 bg-gray-100">
                <div class="bg-white p-6 rounded shadow-sm border border-gray-200">
                    <h2 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-car mr-2"></i> Daftar Mobil
                    </h2>
                    <div class="border-b border-gray-300 mb-4"></div>

                    <!-- Tambah Mobil and Search -->
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('dealer.mobil.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            <i class="fas fa-plus mr-2"></i> Tambah Mobil
                        </a>
                        <div class="flex items-center">
                            <input type="text" placeholder="Cari mobil..." class="px-4 py-2 border border-gray-300 rounded-l focus:outline-none">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-r hover:bg-blue-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-center">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-4 border">No</th>
                                    <th class="px-4 py-4 border">Gambar</th>
                                    <th class="px-4 py-4 border">Merek</th>
                                    <th class="px-4 py-4 border">Model</th>
                                    <th class="px-4 py-4 border">Tahun</th>
                                    <th class="px-4 py-4 border">Kategori</th>
                                    <th class="px-4 py-4 border">Harga</th>
                                    <th class="px-4 py-4 border">Stok</th>
                                    <th class="px-4 py-4 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($cars as $car)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 border">
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="h-20 w-32 object-contain">
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 border">{{ $car->brand }}</td>
                                    <td class="px-4 py-4 border">{{ $car->model }}</td>
                                    <td class="px-4 py-4 border">{{ $car->year }}</td>
                                    <td class="px-4 py-4 border">{{ $car->category }}</td>
                                    <td class="px-4 py-4 border">Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 border">{{ $car->stock }}</td>
                                    <td class="px-4 py-4 border">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('dealer.mobil.edit', $car->id) }}" class="px-3 py-2 bg-yellow-400 text-white text-sm rounded hover:bg-yellow-500">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('dealer.mobil.destroy', $car->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="px-3 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 delete-btn">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data mobil akan dihapus permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>

    <!-- Dropdown Logic -->
    <script>
        const settingsButton = document.getElementById('settings-menu-button');
        const settingsMenu = document.getElementById('settings-menu');

        settingsButton.addEventListener('click', () => {
            settingsMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>