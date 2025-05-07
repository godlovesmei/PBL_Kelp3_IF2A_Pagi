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
</head>
<body class="bg-gray-100 font-sans">

    <!-- Main Layout -->
    <div class="flex min-h-screen">

        <!-- Include Sidebar -->
        @include('partials.side-deal')

        <!-- Right Section: Navbar + Content -->
        <div class="flex-1 flex flex-col">

            <!-- Include Navbar -->
            @include('partials.nav-deal')

            <!-- Main Content -->
            <main class="flex-1 px-6 pb-10">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JS for Sidebar Toggle -->
    <script>
        document.querySelector('[data-collapse-toggle="sidebar"]').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
