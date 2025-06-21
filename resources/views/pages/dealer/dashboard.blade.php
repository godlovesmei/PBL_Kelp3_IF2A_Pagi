@extends('layouts.dealer')

@section('content')
<div class="min-h-screen bg-gray-100 transition-all duration-300 ease-in-out p-2 sm:p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800 mb-1 leading-tight tracking-tight">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="mb-2 text-gray-500 text-base font-medium">Track your sales, customers and earnings.</p>
            </div>
            <div class="flex gap-2 mt-2 md:mt-0">
                <a href="{{ route('pages.dealer.index') }}" class="inline-flex items-center bg-sky-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-box mr-2"></i>Manage Products
                </a>
                <a href="{{ route('pages.dealer.order-index') }}" class="inline-flex items-center bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition font-semibold">
                    <i class="fas fa-clipboard-check mr-2"></i>Manage Orders
                </a>
            </div>
        </div>

        <!-- Statistic Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-4 gap-y-4 mb-8">
            @php
                $stats = [
                    ['label' => 'Products', 'value' => $totalCars, 'icon' => 'fa-car', 'bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                    ['label' => 'Orders', 'value' => $totalOrders, 'icon' => 'fa-clipboard-list', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                    ['label' => 'Customers', 'value' => $totalCustomers, 'icon' => 'fa-users', 'bg' => 'bg-orange-100', 'text' => 'text-orange-500'],
                    ['label' => 'Total Paid', 'value' => 'Rp' . number_format($totalPaid, 0, ',', '.'), 'icon' => 'fa-wallet', 'bg' => 'bg-green-100', 'text' => 'text-green-600'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-xl p-4 flex flex-col items-start hover:shadow-2xl transition min-w-0 group">
                    <div class="{{ $stat['bg'] }} p-3 rounded-full mb-3 flex items-center justify-center min-w-10 shadow group-hover:scale-110 group-hover:rotate-6 transition">
                        <i class="fas {{ $stat['icon'] }} {{ $stat['text'] }} text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ $stat['label'] }}</div>
                        <div class="text-xl font-extrabold text-gray-800">{{ $stat['value'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Monthly Payment Income Chart -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Monthly Payment Income</h2>
                    <span class="inline-block bg-blue-50 text-gray-700 text-xs px-3 py-1 rounded-full font-semibold">Analytics</span>
                </div>
                <canvas id="monthlyPaidChart" height="60"></canvas>
            </div>
            <!-- Orders & Customers Pie Chart -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-orange-600">Customers vs Orders</h2>
                    <span class="inline-block bg-orange-50 text-orange-700 text-xs px-3 py-1 rounded-full font-semibold">Demographics</span>
                </div>
                <canvas id="customersOrdersPie" height="60"></canvas>
                <div class="flex gap-3 mt-4">
                    <span class="flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-orange-400 mr-1"></span>Customers</span>
                    <span class="flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-indigo-400 mr-1"></span>Orders</span>
                </div>
            </div>
        </div>

        <!-- Table: Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="py-2 px-3">Order ID</th>
                            <th class="py-2 px-3">Customer</th>
                            <th class="py-2 px-3">Product</th>
                            <th class="py-2 px-3">Total</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($recentOrders ?? [] as $order)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-2 px-3 font-mono text-indigo-600">#{{ $order->id }}</td>
                            <td class="py-2 px-3">{{ $order->customer->name ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $order->product->name ?? '-' }}</td>
                            <td class="py-2 px-3">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="py-2 px-3">
                                <span class="inline-block px-2 py-1 text-xs rounded
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-400">No recent orders.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Paid Area Chart
    const ctx = document.getElementById('monthlyPaidChart').getContext('2d');
    const monthlyPaidData = @json($monthlyPaid ?? []);
    const labels = monthlyPaidData.map(item => item.label);
    const totals = monthlyPaidData.map(item => item.total);

    function getGradient(ctx) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(20,184,166,0.18)');
        gradient.addColorStop(1, 'rgba(20,184,166,0.18)');
        return gradient;
    }
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Paid (Rp)',
                data: totals,
                borderColor: '#14B8A6',
                backgroundColor: getGradient(ctx),
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#14B8A6',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `Rp ${context.parsed.y.toLocaleString()}`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { color: "#808080" } },
                x: { ticks: { color: "#808080" } }
            }
        }
    });

    // Customers vs Orders Pie Chart
    const pieCtx = document.getElementById('customersOrdersPie').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Customers', 'Orders'],
            datasets: [{
                data: [{{ $totalCustomers }}, {{ $totalOrders }}],
                backgroundColor: ['#fb923c', '#6366f1'],
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.label}: ${context.parsed}`
                    }
                }
            }
        }
    });
</script>
@endsection
