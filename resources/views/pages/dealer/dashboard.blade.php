@extends('layouts.dealer')

@section('content')
<div class="min-h-screen bg-gray-100 transition-all duration-300 ease-in-out p-2 sm:p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-zinc-800 mb-1 leading-tight tracking-tight">Welcome, {{ Auth::user()->name }}!</h1>
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
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm font-medium text-gray-700">From</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
            class="border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
            class="border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500">
    </div>
    <div>
        <button type="submit"
            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 rounded-md shadow">
            Apply Filter
        </button>
    </div>
</form>


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
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-12 h-[350px]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Monthly Payment Income</h2>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                            Analytics
                        </span>
                    </div>
                <div class="h-full">
                            <canvas id="monthlyPaidChart" class="w-full h-full"></canvas>
            </div>
            </div>
            <!-- Payment Method Distribution Pie Chart -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-700">Payment Type Distribution</h2>
                    <span class="inline-block bg-emerald-50 text-emerald-700 text-xs px-3 py-1 rounded-full font-semibold">Breakdown</span>
                </div>
                @php
                    $pieLabels = array_keys($typeDistribution);
                    $pieTotals = array_values($typeDistribution);
                    $pieColors = ['#14b8a6', '#facc15', '#6366f1'];
                @endphp
                <canvas id="paymentTypePie" height="60"></canvas>
                <div class="flex gap-3 mt-4">
                    @foreach($pieLabels as $i => $lbl)
                        <span class="flex items-center"><span class="inline-block w-3 h-3 rounded-full mr-1" style="background: {{ $pieColors[$i] }}"></span>{{ $lbl }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Products & Top Customers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Top Products</h2>
                <ol class="space-y-2">
                    @forelse($topProducts as $prod)
                        <li class="flex items-center justify-between px-2 py-2 rounded hover:bg-sky-50">
                            <span class="truncate">{{ $prod['name'] }}</span>
                            <span class="font-bold text-sky-700">Rp{{ number_format($prod['total'], 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400 italic py-2">No data.</li>
                    @endforelse
                </ol>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Top Customers</h2>
                <ol class="space-y-2">
                    @forelse($topCustomers as $cust)
                        <li class="flex items-center justify-between px-2 py-2 rounded hover:bg-emerald-50">
                            <span class="truncate">{{ $cust['name'] }}</span>
                            <span class="font-bold text-emerald-700">Rp{{ number_format($cust['total'], 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400 italic py-2">No data.</li>
                    @endforelse
                </ol>
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
                            <td class="py-2 px-3 font-mono text-indigo-600">#{{ $order->order_id }}</td>
                            <td class="py-2 px-3">{{ $order->customer->user->name ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $order->car->model ?? '-' }}</td>
                            <td class="py-2 px-3">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
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

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Activities</h2>
            @if(!empty($recentPaymentActivities))
                <ul>
                    @foreach($recentPaymentActivities as $log)
                        <li class="mb-2 text-sm text-gray-700 flex items-center">
                            <i class="fas fa-receipt text-emerald-500 mr-2"></i>
                            <span class="flex-1">{{ $log['description'] }}</span>
                            <span class="ml-3 text-xs text-gray-400">{{ $log['created_at'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-400 italic">No recent activities.</div>
            @endif
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Paid Area Chart
    const ctx = document.getElementById('monthlyPaidChart').getContext('2d');
    const monthlyPaidData = @json($monthlyPaid ?? []);
    const labels = monthlyPaidData.map(item => item.label); // Sudah include bulan + tahun dari controller
    const totals = monthlyPaidData.map(item => item.total);

    function getGradient(ctx) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(20,184,166,0.18)');
        gradient.addColorStop(1, 'rgba(20,184,166,0.07)');
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
            maintainAspectRatio: false, // ✅ ini penting untuk hindari gepeng
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

    // Payment Type Pie Chart
    const pieLabels = @json($pieLabels ?? []);
    const pieTotals = @json($pieTotals ?? []);
    const pieColors = @json($pieColors ?? []);
    new Chart(document.getElementById('paymentTypePie').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieTotals,
                backgroundColor: pieColors,
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.label}: Rp ${context.parsed.toLocaleString()}`
                    }
                }
            }
        }
    });
</script>
@endsection
