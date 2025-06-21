@extends('layouts.dealer')

@section('content')
<div class="min-h-screen bg-gray-100 transition-all duration-300 ease-in-out p-2 sm:p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1 leading-tight">Analytics & Insights</h1>
                <p class="text-gray-500 text-sm">See why and how your numbers move: breakdowns, trends, and more.</p>
            </div>
            <!-- Quick Export & Date Range -->
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" onclick="window.print()" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-teal-600 text-white hover:bg-teal-700 transition shadow">
                    <i class="fas fa-download mr-2"></i> Export PDF
                </button>
                <button type="button" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-chart-line mr-2"></i> Full Report
                </button>
            </div>
        </div>

<!-- FILTER SECTION -->
<form method="GET" class="mb-6 bg-white p-2 sm:p-4 md:p-6 rounded-xl shadow flex flex-col sm:flex-row sm:flex-wrap gap-y-3 sm:gap-4">
    <div class="flex flex-col sm:flex-row gap-2 flex-1">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Date Start</label>
            <input type="date" name="date_start" value="{{ request('date_start') }}" class="rounded-lg border-gray-200 focus:ring-indigo-500 text-sm px-3 py-2 w-full sm:w-36">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Date End</label>
            <input type="date" name="date_end" value="{{ request('date_end') }}" class="rounded-lg border-gray-200 focus:ring-indigo-500 text-sm px-3 py-2 w-full sm:w-36">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Customer</label>
            <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Customer name..." class="rounded-lg border-gray-200 focus:ring-indigo-500 text-sm px-3 py-2 w-full sm:w-40">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Payment Type</label>
            <select name="payment_type" class="rounded-lg border-gray-200 focus:ring-indigo-500 text-sm px-3 py-2 w-full sm:w-36">
                <option value="">All</option>
                <option value="cash" @selected(request('payment_type')=='cash')>Cash</option>
                <option value="dp" @selected(request('payment_type')=='dp')>Down Payment</option>
                <option value="installment" @selected(request('payment_type')=='installment')>Installment</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Car</label>
            <select name="car_id" class="rounded-lg border-gray-200 focus:ring-indigo-500 text-sm px-3 py-2 w-full sm:w-36">
                <option value="">All</option>
                @if(isset($allCars))
                    @foreach($allCars as $carId => $carCode)
                        <option value="{{ $carId }}" @selected(request('car_id') == $carId)>{{ $carCode }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-teal-600 text-white hover:bg-teal-700 transition shadow">
                <i class="fas fa-search mr-2"></i> Filter
            </button>
        </div>
    </div>
</form>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition min-w-0">
                <div class="bg-green-50 p-3 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Cash</div>
                    <div class="text-lg font-bold text-gray-800 truncate">Rp{{ number_format($totalCash, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition min-w-0">
                <div class="bg-yellow-50 p-3 rounded-full flex items-center justify-center">
                    <i class="fas fa-coins text-yellow-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Down Payment</div>
                    <div class="text-lg font-bold text-gray-800 truncate">Rp{{ number_format($totalDP, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition min-w-0">
                <div class="bg-blue-50 p-3 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-[#6A5ACD] text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Installment</div>
                    <div class="text-lg font-bold text-gray-800 truncate">Rp{{ number_format($totalInstallment, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition min-w-0">
                <div class="bg-emerald-50 p-3 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-pie text-emerald-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Total Income</div>
                    <div class="text-lg font-bold text-gray-800 truncate">Rp{{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Advanced Analytics: Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-8">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-1">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-users text-orange-500"></i>
                    <span class="text-xs text-gray-500 uppercase font-semibold">New Customers (This Month)</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $newCustomers ?? 0 }}</div>
                <div class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up"></i>
                    {{ $customerGrowthRate ?? 0 }}% growth
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-1">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-shopping-cart text-emerald-500"></i>
                    <span class="text-xs text-gray-500 uppercase font-semibold">Orders (This Month)</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $ordersThisMonth ?? 0 }}</div>
                <div class="text-xs text-emerald-600 mt-1">
                    <i class="fas fa-arrow-up"></i>
                    {{ $ordersGrowthRate ?? 0 }}% growth
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-1">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-percentage text-yellow-500"></i>
                    <span class="text-xs text-gray-500 uppercase font-semibold">Conversion Rate</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $conversionRate ?? 0 }}%</div>
                <div class="text-xs text-gray-400 mt-1">
                    From total leads: <b>{{ $totalLeads ?? 0 }}</b>
                </div>
            </div>
        </div>

        <!-- Payment Activities Table -->
        <div class="bg-white rounded-xl shadow p-2 sm:p-4 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                <h2 class="text-base font-semibold text-gray-700">Recent Payment Activities</h2>
                <span class="text-xs text-gray-400 italic">Last 30 days</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700">
                            <th class="px-3 py-2 text-left">Activity</th>
                            <th class="px-3 py-2 text-left">Amount</th>
                            <th class="px-3 py-2 text-left">Payment Type</th>
                            <th class="px-3 py-2 text-left">Customer</th>
                            <th class="px-3 py-2 text-left">Paid at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPaymentActivities as $activity)
                            <tr class="border-t group hover:bg-gray-50">
                                <td class="px-3 py-2 text-gray-700">{{ $activity['description'] }}</td>
                                <td class="px-3 py-2 text-emerald-700 font-semibold">Rp{{ number_format($activity['amount'], 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $activity['payment_type'] }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $activity['customer_name'] ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-400">{{ $activity['created_at'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-gray-400 italic py-4">No recent payment activities.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Analytics/Trends Chart -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Income Trends</h2>
                <canvas id="trendsChart" height="40"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Payment Type Distribution</h2>
                <canvas id="typePieChart" height="40"></canvas>
            </div>
        </div>

        <!-- Leaderboard & Best Customers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Top Customers</h2>
                <ol class="space-y-2">
                    @forelse($topCustomers as $customer)
                        <li class="flex items-center justify-between px-2 py-2 rounded-lg hover:bg-indigo-50 transition">
                            <span class="truncate">{{ $customer['name'] }}</span>
                            <span class="font-bold text-indigo-700">Rp{{ number_format($customer['total'], 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400 italic py-4">No data.</li>
                    @endforelse
                </ol>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Sales By Product</h2>
                <ol class="space-y-2">
                    @forelse($topProducts as $product)
                        <li class="flex items-center justify-between px-2 py-2 rounded-lg hover:bg-indigo-50 transition">
                            <span class="truncate">{{ $product['name'] }}</span>
                            <span class="font-bold text-emerald-600">Rp{{ number_format($product['total'], 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400 italic py-4">No data.</li>
                    @endforelse
                </ol>
            </div>
        </div>

        <!-- Insights Section -->
        <div class="bg-white rounded-xl shadow p-4 mb-8">
            <h2 class="text-base font-semibold mb-3 text-gray-700">AI Quick Insights</h2>
            <ul class="list-disc pl-5 space-y-1 text-gray-700 text-sm">
                <li>Cash increased by <span class="font-semibold text-emerald-600">{{ $cashGrowth ?? '0%' }}</span> compared to last period.</li>
                <li>Installment transactions are <span class="font-semibold text-indigo-600">{{ $installmentTrend ?? 'stable' }}</span> this month.</li>
                <li>Conversion rate improved by <span class="font-semibold text-green-600">{{ $conversionRateGrowth ?? '0%' }}</span>.</li>
                <li>Top customer: <span class="font-semibold text-indigo-700">{{ $topCustomers[0]['name'] ?? '-' }}</span>.</li>
                <li>Best product: <span class="font-semibold text-emerald-600">{{ $topProducts[0]['name'] ?? '-' }}</span>.</li>
            </ul>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Trends Chart
    const trendsData = @json($trendsData ?? []);
    const trendLabels = trendsData.map(item => item.label);
    const trendTotals = trendsData.map(item => item.total);

    const ctx = document.getElementById('trendsChart').getContext('2d');
    function getGradient(ctx) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 120);
        gradient.addColorStop(0, 'rgba(99,102,241,0.22)');
        gradient.addColorStop(1, 'rgba(99,102,241,0.02)');
        return gradient;
    }
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Income (Rp)',
                data: trendTotals,
                backgroundColor: getGradient(ctx),
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 6,
                hoverBackgroundColor: '#6366f1',
                hoverBorderColor: '#6366f1',
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

    // Payment Type Pie Chart
    const typeDistData = @json($typeDistribution ?? []);
    const typeLabels = typeDistData.map(item => item.label);
    const typeTotals = typeDistData.map(item => item.total);
    const pieColors = ['#34d399','#fbbf24','#6366f1','#f87171'];

    new Chart(document.getElementById('typePieChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: typeLabels,
            datasets: [{
                label: 'Payment Types',
                data: typeTotals,
                backgroundColor: pieColors,
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
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
