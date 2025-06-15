@extends('layouts.dealer')

@section('content')
<div class="min-h-screen bg-gray-100 transition-all duration-300 ease-in-out p-4 md:p-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Ready for work today, {{ Auth::user()->name }}?</h1>
        <p class="mb-4 text-gray-500 text-sm md:text-base">Your dealership summary and recent activities at a glance.</p>

        <!-- FILTER SECTION -->
        <form method="GET" class="mb-6 bg-white p-4 md:p-6 rounded-xl shadow flex flex-col md:flex-row md:items-end gap-3 md:gap-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1" for="date_from">From</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filter['date_from'] ?? '' }}" class="rounded border-gray-300 px-2 py-1 text-sm w-full">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1" for="date_to">To</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filter['date_to'] ?? '' }}" class="rounded border-gray-300 px-2 py-1 text-sm w-full">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1" for="payment_method">Payment</label>
                <select id="payment_method" name="payment_method" class="rounded border-gray-300 px-2 py-1 text-sm w-full">
                    <option value="">All</option>
                    <option value="cash" {{ $filter['payment_method'] == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="dp" {{ $filter['payment_method'] == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="installment" {{ $filter['payment_method'] == 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1" for="customer_id">Customer</label>
                <select id="customer_id" name="customer_id" class="rounded border-gray-300 px-2 py-1 text-sm w-full">
                    <option value="">All</option>
                    @foreach ($allCustomers as $cid => $cname)
                        <option value="{{ $cid }}" {{ $filter['customer_id'] == $cid ? 'selected' : '' }}>{{ $cname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1" for="car_id">Product</label>
                <select id="car_id" name="car_id" class="rounded border-gray-300 px-2 py-1 text-sm w-full">
                    <option value="">All</option>
                    @foreach ($allCars as $id => $name)
                        <option value="{{ $id }}" {{ $filter['car_id'] == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-1.5 rounded bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>

        <!-- Statistic Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 mb-6">
            @php
                $stats = [
                    ['label' => 'Products', 'value' => $totalCars, 'icon' => 'fa-car', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    ['label' => 'Orders', 'value' => $totalOrders, 'icon' => 'fa-clipboard-list', 'bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                    ['label' => 'Customers', 'value' => $totalCustomers, 'icon' => 'fa-users', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                    ['label' => 'Total Paid', 'value' => 'Rp' . number_format($totalPaid, 0, ',', '.'), 'icon' => 'fa-wallet', 'bg' => 'bg-green-100', 'text' => 'text-green-600'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center hover:shadow-lg transition">
                    <div class="{{ $stat['bg'] }} p-2 rounded-full mr-3 flex items-center justify-center">
                        <i class="fas {{ $stat['icon'] }} {{ $stat['text'] }} text-lg"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-gray-500 uppercase">{{ $stat['label'] }}</div>
                        <div class="text-lg font-bold text-gray-800">{{ $stat['value'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Payment Breakdown Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-5 mb-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center hover:shadow-md transition">
                <div class="bg-green-50 p-2 rounded-full mr-3 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Cash</div>
                    <div class="text-base font-bold text-gray-800">Rp{{ number_format($totalCash, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center hover:shadow-md transition">
                <div class="bg-yellow-50 p-2 rounded-full mr-3 flex items-center justify-center">
                    <i class="fas fa-coins text-yellow-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">DP</div>
                    <div class="text-base font-bold text-gray-800">Rp{{ number_format($totalDP, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center hover:shadow-md transition">
                <div class="bg-blue-50 p-2 rounded-full mr-3 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Installment</div>
                    <div class="text-base font-bold text-gray-800">Rp{{ number_format($totalInstallment, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Monthly Paid Chart -->
        <div class="bg-white rounded-xl shadow p-4 mb-8">
            <h2 class="text-base font-semibold mb-3 text-gray-700">Monthly Payment Income</h2>
            <div class="w-full">
                <canvas id="monthlyPaidChart" height="38"></canvas>
            </div>
        </div>

        <!-- Recent Payment Activities -->
        <div class="bg-white rounded-xl shadow p-4 mb-8">
            <h2 class="text-base font-semibold mb-3 text-gray-700">Recent Payment Activities</h2>
            <ul class="divide-y divide-gray-100 max-h-52 overflow-y-auto">
                @forelse($recentPaymentActivities as $activity)
                    <li class="py-2 flex items-start group hover:bg-gray-50 rounded px-1 transition">
                        <div class="flex-shrink-0 mt-1">
                            @php
                                $iconMap = [
                                    'Cash' => ['fa-money-bill-wave', 'text-green-500'],
                                    'Dp' => ['fa-coins', 'text-yellow-500'],
                                    'Installment' => ['fa-calendar-alt', 'text-blue-500'],
                                ];
                                $method = ucfirst(Str::before(Str::after($activity['description'], 'Pembayaran '), ' untuk'));
                                $icon = $iconMap[$method][0] ?? 'fa-receipt';
                                $iconColor = $iconMap[$method][1] ?? 'text-blue-500';
                            @endphp
                            <i class="fas {{ $icon }} text-xs {{ $iconColor }}"></i>
                        </div>
                        <div class="ml-2">
                            <p class="text-xs text-gray-700">
                                {{ $activity['description'] }}
                                <span class="text-indigo-600 font-semibold">(Rp {{ number_format($activity['amount'], 0, ',', '.') }})</span>
                            </p>
                            <p class="text-[10px] text-gray-400">{{ $activity['time'] }} <span class="ml-2 text-gray-300">|</span> <span class="text-gray-500">{{ $activity['created_at'] }}</span></p>
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-gray-400 italic text-xs">No recent payment activities.</li>
                @endforelse
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5">
            <a href="{{ route('pages.dealer.index') }}" class="border border-gray-200 rounded-xl p-4 bg-white hover:shadow-md transition flex items-center">
                <i class="fas fa-box mr-3 text-lg text-indigo-500"></i>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Manage Products</h3>
                    <p class="text-xs text-gray-600">Add, edit, or delete your car listings.</p>
                </div>
            </a>
            <a href="{{ route('pages.dealer.order-index') }}" class="border border-gray-200 rounded-xl p-4 bg-white hover:shadow-md transition flex items-center">
                <i class="fas fa-clipboard-check mr-3 text-lg text-pink-500"></i>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Manage Orders</h3>
                    <p class="text-xs text-gray-600">View and process customer orders.</p>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyPaidChart').getContext('2d');
    const monthlyPaidData = @json($monthlyPaid ?? []);
    const labels = monthlyPaidData.map(item => item.label);
    const totals = monthlyPaidData.map(item => item.total);

    function getGradient(ctx) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 120);
        gradient.addColorStop(0, 'rgba(99,102,241,0.10)');
        gradient.addColorStop(1, 'rgba(99,102,241,0.01)');
        return gradient;
    }
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Paid (Rp)',
                data: totals,
                borderColor: '#6366f1',
                backgroundColor: getGradient(ctx),
                fill: true,
                tension: 0.3,
                pointRadius: 3,
                pointBackgroundColor: '#6366f1'
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
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
