<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venus Cars | Dealer</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Belleza&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dealerlayout.css') }}">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow z-20">
        <div class="flex justify-between items-center px-6 py-3">
            <div class="branding">
                <h1 class="text-2xl font-bold text-gray-800" style="font-family: 'Great Vibes', cursive;">Venus Cars</h1>
                <p class="text-sm text-gray-500" style="font-family: 'Belleza', sans-serif;">Dealer Center</p>
            </div>
            <div class="icon">
                <a href="{{ route('dealer.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-2 text-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('dealer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="fixed top-16 left-0 w-60 h-screen bg-gray-800 text-white p-4">

        <nav class="space-y-2">
            <a href="{{ route('dealer.dashboard') }}"
               class="flex items-center gap-2 px-4 py-2 rounded {{ request()->routeIs('dealer.dashboard') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('dealer.mobil') }}"
               class="flex items-center gap-2 px-4 py-2 rounded {{ request()->routeIs('dealer.mobil') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <i class="fas fa-car"></i> Daftar Mobil
            </a>
            <a href="{{ route('dealer.mobil.create') }}"
               class="flex items-center gap-2 px-4 py-2 rounded {{ request()->routeIs('dealer.mobil.create') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <i class="fas fa-plus-circle"></i> Tambah Mobil
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ml-60 pt-20 px-6 pb-10">
        @yield('content')
    </main>

</body>
</html>