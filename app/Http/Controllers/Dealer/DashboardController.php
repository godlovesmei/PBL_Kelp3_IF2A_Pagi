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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dealerId = Auth::id();

        // --- Filter (optional, for drilldown) ---
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $carId = $request->input('car_id');
        $paymentMethod = $request->input('payment_method');

        // --- Base payment query for filter ---
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
            // Robust: in_array for DP/down_payment/downpayment
            if ($paymentMethod === 'dp') {
                $paymentsQuery->whereIn('payment_method', ['dp', 'down_payment', 'downpayment']);
            } else {
                $paymentsQuery->where('payment_method', $paymentMethod);
            }
        }

        // --- High level stats ---
        $totalCars = Car::where('dealer_id', $dealerId)->count();
        $totalOrders = Order::whereHas('car', function($q) use ($dealerId, $carId) {
            $q->where('dealer_id', $dealerId);
            if ($carId) $q->where('id', $carId);
        })->count();
        $totalCustomers = Order::whereHas('car', function($q) use ($dealerId, $carId) {
            $q->where('dealer_id', $dealerId);
            if ($carId) $q->where('id', $carId);
        })->distinct('cust_id')->count('cust_id');
        $totalPaid = (clone $paymentsQuery)->sum('amount');

        // --- Payment breakdown ---
        $totalCash = (clone $paymentsQuery)->where('payment_method', 'cash')->sum('amount');
        $totalDP = (clone $paymentsQuery)->whereIn('payment_method', ['dp', 'down_payment', 'downpayment'])->sum('amount');
        $totalInstallment = (clone $paymentsQuery)->where('payment_method', 'installment')->sum('amount');

        // --- Monthly paid chart (current year) ---
        $now = Carbon::now('Asia/Jakarta');
        $monthlyPaid = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($now->year, $m, 1, 0, 0, 0, 'Asia/Jakarta');
            $total = (clone $paymentsQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
            $monthlyPaid[] = [
                'label' => $month->format('M Y'),
                'total' => $total,
            ];
        }

        // --- Top products (by payment value) ---
        $topProducts = (clone $paymentsQuery)
            ->get()
            ->groupBy(function($p) {
                return $p->order->car->model ?? '-';
            })
            ->map(function($group, $name){
                return [
                    'name' => $name,
                    'total' => $group->count() > 0 ? $group->sum('amount') : 0,
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values()
            ->toArray();

        // --- Top customers (by payment value) ---
        $topCustomers = (clone $paymentsQuery)
            ->get()
            ->groupBy(function($p) {
                return $p->order->customer->user->name ?? '-';
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

        // --- Payment type distribution for pie chart ---
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

        // --- Recent Activities (payments + orders) ---
        $recentPayments = (clone $paymentsQuery)->latest()->take(5)->get()->map(function($pay) {
            return [
                'type' => 'payment',
                'description' => 'Payment ' . ucfirst($pay->payment_method) .
                    ' for order #' . ($pay->order->order_id ?? '-') .
                    ' by ' . ($pay->order->customer->user->name ?? 'Customer'),
                'amount' => $pay->amount,
                'time' => $pay->created_at ? Carbon::parse($pay->created_at)->timezone('Asia/Jakarta')->diffForHumans() : '-',
                'created_at' => $pay->created_at ? Carbon::parse($pay->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') : '-',
            ];
        })->toArray();

        $recentOrders = Order::with(['car', 'customer.user'])
            ->whereHas('car', function($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->latest('created_at')->take(5)->get();

        // --- Notification Area (for example) ---
        $dealerUser = Auth::user();
        $notifications = $dealerUser->notifications()->latest()->take(10)->get();
        $unreadCount = $dealerUser->unreadNotifications()->count();

        // --- Filter Lists ---
        $allCars = Car::where('dealer_id', $dealerId)->pluck('model', 'id');

        return view('pages.dealer.dashboard', [
            'totalCars'        => $totalCars,
            'totalOrders'      => $totalOrders,
            'totalCustomers'   => $totalCustomers,
            'totalPaid'        => $totalPaid,
            'totalCash'        => $totalCash,
            'totalDP'          => $totalDP,
            'totalInstallment' => $totalInstallment,
            'monthlyPaid'      => $monthlyPaid,
            'typeDistribution' => $typeDistribution,
            'topProducts'      => $topProducts,
            'topCustomers'     => $topCustomers,
            'recentPaymentActivities' => $recentPayments,
            'recentOrders'     => $recentOrders,
            'allCars'          => $allCars,
            'notifications'    => $notifications,
            'unreadCount'      => $unreadCount,
            'filter'           => [
                'date_from'      => $dateFrom,
                'date_to'        => $dateTo,
                'car_id'         => $carId,
                'payment_method' => $paymentMethod,
            ],
        ]);
    }
}
