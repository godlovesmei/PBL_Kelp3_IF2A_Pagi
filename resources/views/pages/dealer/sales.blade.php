@extends('layouts.dealer')

@section('content')
<div class="p-6 bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-blue-700 mb-2 tracking-tight drop-shadow">🚗 Sales Overview</h1>
        <p class="text-gray-500 mb-6">Monitor your dealership's performance and trends at a glance.</p>

        <!-- Filter -->
        <form method="GET" class="bg-white/80 backdrop-blur-lg p-5 rounded-xl shadow-xl mb-8 grid grid-cols-1 md:grid-cols-4 gap-6 border border-blue-100">
            <div>
                <label for="date_from" class="block text-xs font-bold text-blue-800 uppercase mb-1">From</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full mt-1 rounded-lg border-blue-300 focus:ring-2 focus:ring-blue-400 shadow-sm px-3 py-2 text-sm">
            </div>
            <div>
                <label for="date_to" class="block text-xs font-bold text-blue-800 uppercase mb-1">To</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full mt-1 rounded-lg border-blue-300 focus:ring-2 focus:ring-blue-400 shadow-sm px-3 py-2 text-sm">
            </div>
            <div>
                <label for="car_id" class="block text-xs font-bold text-blue-800 uppercase mb-1">Car</label>
                <select name="car_id" id="car_id" class="w-full mt-1 rounded-lg border-blue-300 focus:ring-2 focus:ring-blue-400 shadow-sm px-3 py-2 text-sm">
                    <option value="">All Models</option>
                    @foreach($allCars as $id => $model)
                        <option value="{{ $id }}" @selected(request('car_id') == $id)>{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-700 to-green-500 text-white font-bold py-2.5 rounded-lg shadow-lg hover:from-blue-800 hover:to-green-600 transition">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 19a2 2 0 01-2-2V7a2 2 0 012-2h9a2 2 0 012 2v2m-2 4h6m0 0l-2-2m2 2l-2 2"></path></svg>
                        Filter
                    </span>
                </button>
            </div>
        </form>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-tl from-blue-600/90 to-blue-400/90 p-6 rounded-xl shadow-lg flex flex-col items-center text-white">
                <h3 class="text-xs uppercase font-semibold opacity-80 mb-2">Total Units Sold</h3>
                <p class="text-3xl font-extrabold tracking-wide">{{ $totalUnitsSold }}</p>
            </div>
            <div class="bg-gradient-to-tl from-green-600/90 to-green-400/90 p-6 rounded-xl shadow-lg flex flex-col items-center text-white">
                <h3 class="text-xs uppercase font-semibold opacity-80 mb-2">Total Sales</h3>
                <p class="text-3xl font-extrabold tracking-wide">Rp{{ number_format($totalSalesValue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="bg-white/90 rounded-xl shadow-xl mb-8 px-3 py-7 border-t-4 border-blue-600">
            <h2 class="text-lg font-semibold text-blue-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"></path></svg>
                Monthly Sales
            </h2>
            <div class="w-full overflow-x-auto">
                <canvas id="monthlySalesChart" height="90"></canvas>
            </div>
        </div>
        <!-- Sales Distribution by Model -->
<div class="bg-white/90 rounded-xl shadow-xl mb-8 px-3 py-7 border-t-4 border-green-600">
    <h2 class="text-lg font-semibold text-green-700 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-green-500" ...></svg>
        Sales Distribution by Car Model
    </h2>
    <div class="w-full flex justify-center">
        <canvas id="salesByModelChart" height="120"></canvas>
    </div>
</div>

<!-- Cumulative Sales Trend -->
<div class="bg-white/90 rounded-xl shadow-xl mb-8 px-3 py-7 border-t-4 border-indigo-600">
    <h2 class="text-lg font-semibold text-indigo-700 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-indigo-500" ...></svg>
        Cumulative Sales Trend
    </h2>
    <div class="w-full overflow-x-auto">
        <canvas id="cumulativeSalesChart" height="100"></canvas>
    </div>
</div>

        <!-- Sales per Model -->
        <div class="bg-white/90 rounded-xl shadow-xl px-6 py-7 border-t-4 border-green-400">
            <h2 class="text-lg font-semibold text-green-700 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"></path></svg>
                Sales per Car Model
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase bg-gradient-to-r from-green-50 to-blue-50 text-blue-700">
                        <tr>
                            <th class="px-5 py-3">Model</th>
                            <th class="px-5 py-3">Units Sold</th>
                            <th class="px-5 py-3">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salesPerModel as $model)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-5 py-3 font-medium">{{ $model['model'] }}</td>
                            <td class="px-5 py-3 text-center">{{ $model['units_sold'] }}</td>
                            <td class="px-5 py-3 font-bold text-green-700">Rp{{ number_format($model['total_sales'], 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-3 text-center text-gray-400">No sales data available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlySalesChart = new Chart(document.getElementById('monthlySalesChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($monthlySales)->pluck('label')) !!},
            datasets: [
                {
                    label: 'Units Sold',
                    data: {!! json_encode(collect($monthlySales)->pluck('units_sold')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.85)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Total Sales (Rp)',
                    data: {!! json_encode(collect($monthlySales)->pluck('total_sales')) !!},
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#1e293b',
                        font: { weight: 'bold', size: 14 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.parsed.y;
                            if (context.datasetIndex === 1) {
                                return `${label}: Rp${value.toLocaleString('id-ID')}`;
                            }
                            return `${label}: ${value}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#1e293b',
                        font: { weight: 'bold' }
                    },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#1e293b',
                        callback: function(value, index, values) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: '#bae6fd',
                        borderDash: [2, 2],
                    }
                }
            }
        }
    });

    // Doughnut chart for sales by model
const salesByModelChart = new Chart(document.getElementById('salesByModelChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(collect($salesPerModel)->pluck('model')) !!},
        datasets: [{
            data: {!! json_encode(collect($salesPerModel)->pluck('units_sold')) !!},
            backgroundColor: [
                '#3b82f6', '#10b981', '#f59e42', '#ef4444', '#6366f1', '#fbbf24', '#e11d48', '#a21caf', '#14b8a6', '#f472b6', '#fde047', '#a3e635'
            ],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        plugins: {
            legend: { position: 'right' }
        }
    }
});

// Line chart for cumulative sales
const cumulativeSalesChart = new Chart(document.getElementById('cumulativeSalesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($cumulativeMonthlySales)->pluck('label')) !!},
        datasets: [
            {
                label: 'Cumulative Units Sold',
                data: {!! json_encode(collect($cumulativeMonthlySales)->pluck('cumulative_units')) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                borderWidth: 2,
            },
            {
                label: 'Cumulative Sales (Rp)',
                data: {!! json_encode(collect($cumulativeMonthlySales)->pluck('cumulative_sales')) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                borderWidth: 2,
                yAxisID: 'y1',
            },
        ]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                title: { display: true, text: 'Units' }
            },
            y1: {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                grid: { drawOnChartArea: false },
                title: { display: true, text: 'Rp' },
                ticks: {
                    callback: function(value) {
                        return 'Rp' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endsection
