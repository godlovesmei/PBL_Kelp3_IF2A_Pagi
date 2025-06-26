<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Car;
use App\Models\Customer;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dealerId = Auth::id();

        // Date filter, default to current month
        $dateStart = $request->input('date_start') ?: Carbon::now()->startOfMonth()->toDateString();
        $dateEnd = $request->input('date_end') ?: Carbon::now()->endOfMonth()->toDateString();

        // Other filters
        $customer = $request->input('customer');
        $paymentType = $request->input('payment_type');
        $carId = $request->input('car_id');

        // Payment query builder
        $paymentsQuery = Payment::query()
            ->whereHas('order.car', function ($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->with(['order.car', 'order.customer.user'])
            ->whereBetween('payment_date', [$dateStart, $dateEnd]);

        if ($paymentType) {
            if ($paymentType === 'dp') {
                $paymentsQuery->whereIn('payment_method', ['dp', 'down_payment', 'downpayment']);
            } elseif ($paymentType === 'cash') {
                $paymentsQuery->where('payment_method', 'cash');
            } elseif ($paymentType === 'installment') {
                $paymentsQuery->where('payment_method', 'installment');
            }
        }

        if ($customer) {
            $paymentsQuery->whereHas('order.customer.user', function ($q) use ($customer) {
                $q->where('name', 'like', "%$customer%");
            });
        }

        if ($carId) {
            $paymentsQuery->whereHas('order', function ($q) use ($carId) {
                $q->where('car_id', $carId);
            });
        }

        // KPI Data
        $totalCash = (clone $paymentsQuery)->where('payment_method', 'cash')->sum('amount');
        $totalDP = (clone $paymentsQuery)->whereIn('payment_method', ['dp', 'down_payment', 'downpayment'])->sum('amount');
        $totalInstallment = (clone $paymentsQuery)->where('payment_method', 'installment')->sum('amount');
        $totalIncome = (clone $paymentsQuery)->sum('amount');

        // Recent Activities
        $recentPaymentActivities = (clone $paymentsQuery)
            ->latest('payment_date')
            ->take(12)
            ->get()
            ->map(function ($p) {
                return [
                    'description' => $p->order->car->model ?? '-',
                    'amount' => $p->amount,
                    'payment_type' => ucfirst(str_replace('_', ' ', $p->payment_method ?? '-')),
                    'customer_name' => $p->order->customer->user->name ?? '-',
                    'created_at' => $p->payment_date ? Carbon::parse($p->payment_date)->format('Y-m-d') : '-',
                ];
            });

// Trends Chart (per month for current year) -- gunakan Payment query baru, BUKAN $paymentsQuery!
$now = Carbon::now();
$trendsData = [];
for ($m = 1; $m <= 12; $m++) {
    $total = Payment::whereHas('order.car', function ($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })
        // Optional: filter lain (misal, carId, paymentType, customer) jika memang ingin
        ->whereYear('payment_date', $now->year)
        ->whereMonth('payment_date', $m)
        ->sum('amount');
    $trendsData[] = [
        'label' => Carbon::create($now->year, $m, 1)->format('M'),
        'total' => $total,
    ];
}

        // Payment Type Distribution for pie chart (dynamic, robust)
        $typeDistributionRaw = (clone $paymentsQuery)
            ->selectRaw("LOWER(payment_method) as payment_method, SUM(amount) as total")
            ->groupBy('payment_method')
            ->get();

        $typeDistribution = [
            'Cash' => 0,
            'Down Payment' => 0,
            'Installment' => 0,
        ];

        foreach ($typeDistributionRaw as $row) {
            $method = trim(strtolower($row->payment_method));
            $label = match (true) {
                $method === 'cash' => 'Cash',
                in_array($method, ['dp', 'down_payment', 'downpayment']) => 'Down Payment',
                $method === 'installment' => 'Installment',
                default => ucfirst(str_replace('_', ' ', $row->payment_method)),
            };
            if (isset($typeDistribution[$label])) {
                $typeDistribution[$label] += $row->total;
            } else {
                $typeDistribution[$label] = $row->total;
            }
        }

        // New Customers & Growth (this month vs last month)
        $monthStart = Carbon::parse($dateStart)->startOfMonth();
        $monthEnd = Carbon::parse($dateEnd)->endOfMonth();
        $lastMonthStart = $monthStart->copy()->subMonth();
        $lastMonthEnd = $monthEnd->copy()->subMonth();

        $customerIdsThisMonth = Order::whereHas('car', function($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->pluck('cust_id')
            ->unique();

        $newCustomers = Customer::whereIn('cust_id', $customerIdsThisMonth)->count();

        $customerIdsLastMonth = Order::whereHas('car', function($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->pluck('cust_id')
            ->unique();

        $lastMonthCustomers = Customer::whereIn('cust_id', $customerIdsLastMonth)->count();

        $customerGrowthRate = ($lastMonthCustomers > 0)
            ? round((($newCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100, 1)
            : ($newCustomers > 0 ? 100 : 0);

        // Orders this month & growth
        $ordersThisMonth = Order::whereHas('car', function($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $ordersLastMonth = Order::whereHas('car', function($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $ordersGrowthRate = ($ordersLastMonth > 0)
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : ($ordersThisMonth > 0 ? 100 : 0);

        // Conversion rate (orders / leads)
        $totalLeads = Order::whereHas('car', function($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })->pluck('cust_id')->unique()->count();
        $conversionRate = $totalLeads > 0
            ? round(($ordersThisMonth / $totalLeads) * 100, 1)
            : 0;
        $conversionRateGrowth = $conversionRate > 0 ? '+' . $conversionRate . '%' : '0%';

        // Top Customers (by payment sum)
        $topCustomers = (clone $paymentsQuery)
            ->get()
            ->groupBy(function($p) {
                return $p->order->customer->user->name ?? '-';
            })
            ->map(function($group, $name) {
                return [
                    'name' => $name,
                    'total' => $group->sum('amount'),
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values()
            ->toArray();

        // Top Products (by car model)
        $topProducts = (clone $paymentsQuery)
            ->get()
            ->groupBy(function($p){
                return $p->order->car->model ?? '-';
            })
            ->map(function($group, $name){
                return [
                    'name' => $name,
                    'total' => $group->sum('amount'),
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values()
            ->toArray();

        // AI Insights
        $lastMonthCash = (clone $paymentsQuery)
            ->where('payment_method', 'cash')
            ->whereBetween('payment_date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        $cashGrowth = ($lastMonthCash > 0)
            ? round((($totalCash - $lastMonthCash) / $lastMonthCash) * 100, 1) . '%'
            : ($totalCash > 0 ? '100%' : '0%');
        $installmentTrend = $totalInstallment > 0 ? 'stable' : 'down';

        // List mobil untuk filter
        $allCars = Car::where('dealer_id', $dealerId)->pluck('model', 'id');

        return view('pages.dealer.analytics', [
            'totalCash' => $totalCash,
            'totalDP' => $totalDP,
            'totalInstallment' => $totalInstallment,
            'totalIncome' => $totalIncome,
            'recentPaymentActivities' => $recentPaymentActivities,
            'trendsData' => $trendsData,
            'typeDistribution' => $typeDistribution,
            'allCars' => $allCars,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'newCustomers' => $newCustomers,
            'customerGrowthRate' => $customerGrowthRate,
            'ordersThisMonth' => $ordersThisMonth,
            'ordersGrowthRate' => $ordersGrowthRate,
            'conversionRate' => $conversionRate,
            'conversionRateGrowth' => $conversionRateGrowth,
            'totalLeads' => $totalLeads,
            'topCustomers' => $topCustomers,
            'topProducts' => $topProducts,
            'cashGrowth' => $cashGrowth,
            'installmentTrend' => $installmentTrend,
        ]);
    }
}
