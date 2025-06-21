<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dealerId = Auth::id();
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $customerName = $request->input('customer');
        $paymentMethod = $request->input('payment_type'); // cash|dp|installment
        $carId = $request->input('car_id');

        $paymentsQuery = Payment::with(['order.car', 'order.customer.user'])
            ->whereHas('order.car', function($q) use ($dealerId, $carId) {
                $q->where('dealer_id', $dealerId);
                if ($carId) $q->where('id', $carId);
            });
if ($dateFrom) {
    $paymentsQuery->whereDate('created_at', '>=', $dateFrom);
}
if ($dateTo) {
    $paymentsQuery->whereDate('created_at', '<=', $dateTo);
}
if ($paymentMethod) {
    $paymentsQuery->where('payment_method', $paymentMethod);
}
if ($customerName) {
    $paymentsQuery->whereHas('order.customer.user', function($q) use ($customerName) {
        $q->where('name', 'like', '%' . $customerName . '%');
    });
}

        // Payment Breakdown
        $totalCash = (clone $paymentsQuery)->where('payment_method', 'cash')->sum('amount');
        $totalDP = (clone $paymentsQuery)->where('payment_method', 'dp')->sum('amount');
        $totalInstallment = (clone $paymentsQuery)->where('payment_method', 'installment')->sum('amount');
        $totalIncome = $totalCash + $totalDP + $totalInstallment;

        // Activities detail (ambil lebih banyak, misal 30)
        $recentPayments = (clone $paymentsQuery)->latest()->take(30)->get();
        $recentPaymentActivities = $recentPayments->map(function($pay) {
            return [
                'type' => 'payment',
                'description' => 'Payment ' . ucfirst($pay->payment_method) .
                    ' for order #' . ($pay->order->order_id ?? '-') .
                    ' by ' . ($pay->order->customer->user->name ?? 'Customer'),
                'amount' => $pay->amount,
                'payment_type' => ucfirst($pay->payment_method),
                'customer_name' => $pay->order->customer->user->name ?? '-',
                'time' => $pay->created_at ? Carbon::parse($pay->created_at)->timezone('Asia/Jakarta')->diffForHumans() : '-',
                'created_at' => $pay->created_at ? Carbon::parse($pay->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') : '-',
            ];
        })->toArray();

        // Trends chart (income per bulan)
        $trendsData = [];
        $now = Carbon::now('Asia/Jakarta');
        $startOfMonth = $now->copy()->startOfMonth()->startOfDay();
        $endOfMonth = $now->copy()->endOfMonth()->endOfDay();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth()->startOfDay();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth()->endOfDay();

        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($now->year, $m, 1, 0, 0, 0, 'Asia/Jakarta');
            $total = (clone $paymentsQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
            $trendsData[] = [
                'label' => $month->format('M'),
                'total' => $total
            ];
        }

        // Payment type distribution for pie
        $typeDistribution = [
            ['label' => 'Cash', 'total' => $totalCash],
            ['label' => 'Down Payment', 'total' => $totalDP],
            ['label' => 'Installment', 'total' => $totalInstallment],
        ];

        // New customers & growth (this month vs last month)
        $customerIdsThisMonth = Order::whereHas('car', function($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->pluck('cust_id')
        ->unique();

        $newCustomers = Customer::whereIn('cust_id', $customerIdsThisMonth)->count();

        $customerIdsLastMonth = Order::whereHas('car', function($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })
        ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
        ->pluck('cust_id')
        ->unique();

        $lastMonthCustomers = Customer::whereIn('cust_id', $customerIdsLastMonth)->count();

        // Orders this month & growth
        $ordersThisMonth = Order::whereHas('car', function($q) use ($dealerId) { $q->where('dealer_id', $dealerId); })
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        $ordersLastMonth = Order::whereHas('car', function($q) use ($dealerId) { $q->where('dealer_id', $dealerId); })
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $ordersGrowthRate = $ordersLastMonth > 0
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : ($ordersThisMonth > 0 ? 100 : 0);

        // Conversion rate (orders / leads)
        $totalLeads = Order::whereHas('car', function($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })->pluck('cust_id')->unique()->count();
        $conversionRate = $totalLeads > 0
            ? round(($ordersThisMonth / $totalLeads) * 100, 1)
            : 0;

        // Top customers
        $topCustomers = Payment::with(['order.customer.user'])
            ->whereHas('order.car', function($q) use ($dealerId) { $q->where('dealer_id', $dealerId); })
            ->selectRaw('order_id, SUM(amount) as total')
            ->groupBy('order_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($pay) {
                $customerName = $pay->order->customer->user->name ?? '-';
                return [
                    'name' => $customerName,
                    'total' => $pay->total,
                ];
            })->toArray();

        // Top products (cars)
        $topProducts = Payment::with(['order.car'])
            ->whereHas('order.car', function($q) use ($dealerId) { $q->where('dealer_id', $dealerId); })
            ->selectRaw('order_id, SUM(amount) as total')
            ->groupBy('order_id')
            ->get()
            ->groupBy(function ($pay) {
                return $pay->order->car->car_code ?? '-';
            })
            ->map(function ($pays, $carCode) {
                return [
                    'name' => $carCode,
                    'total' => $pays->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values()
            ->take(5)
            ->toArray();

        // Insights/AI (dummy sample)
        $lastMonthCash = (clone $paymentsQuery)->where('payment_method', 'cash')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('amount');
        $cashGrowth = $totalCash > 0 && $lastMonthCash
            ? round((($totalCash - $lastMonthCash) / max(1, $lastMonthCash)) * 100, 1) . '%'
            : '0%';
        $installmentTrend = $totalInstallment > 0 ? 'stable' : 'down';
        $conversionRateGrowth = $conversionRate > 0 ? '+'.($conversionRate).'%' : '0%';

        // List mobil untuk filter
        $allCars = Car::where('dealer_id', $dealerId)->pluck('car_code', 'id');

        return view('pages.dealer.analytics', [
            'totalCash' => $totalCash,
            'totalDP' => $totalDP,
            'totalInstallment' => $totalInstallment,
            'totalIncome' => $totalIncome,
            'recentPaymentActivities' => $recentPaymentActivities,
            'trendsData' => $trendsData,
            'typeDistribution' => $typeDistribution,
            'allCars' => $allCars,
            'filter' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'payment_method' => $paymentMethod,
                'car_id' => $carId,
            ],
            'newCustomers' => $newCustomers,

            'ordersThisMonth' => $ordersThisMonth,
            'ordersGrowthRate' => $ordersGrowthRate,
            'conversionRate' => $conversionRate,
            'totalLeads' => $totalLeads,
            'topCustomers' => $topCustomers,
            'topProducts' => $topProducts,
            'cashGrowth' => $cashGrowth,
            'installmentTrend' => $installmentTrend,
            'conversionRateGrowth' => $conversionRateGrowth,
        ]);
    }
}
