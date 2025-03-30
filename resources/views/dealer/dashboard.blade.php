<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dealer Dashboard</title>
    <style>
        body { display: flex; }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Dealer Dashboard</h3>
        <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-car"></i> Data Mobil</a>
        <a href="#"><i class="fas fa-users"></i> Data Pelanggan</a>
        <a href="#"><i class="fas fa-cog"></i> Pengaturan</a>
        <form action="{{ route('logout') }}" method="POST" class="d-block mt-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Dealer Dashboard</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-car"></i> Total Mobil</h5>
                        <p class="card-text">Total: {{ $total_mobil }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-building"></i> Total Dealer</h5>
                        <p class="card-text">Total: {{ $total_dealer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
