<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dealerId = Auth::id();

        // Ambil filter dari request
        $dateFrom = $request->input('date_from'); // format: Y-m-d
        $dateTo = $request->input('date_to');     // format: Y-m-d
        $paymentMethod = $request->input('payment_method'); // cash|dp|installment
        $carId = $request->input('car_id');

        // Query dasar Payment
        $paymentsQuery = Payment::with(['order.car', 'order.customer.user'])
            ->whereHas('order.car', function($q) use ($dealerId, $carId) {
                $q->where('dealer_id', $dealerId);
                if ($carId) $q->where('id', $carId);
            });

        // Filter date
        if ($dateFrom) {
            $paymentsQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $paymentsQuery->whereDate('created_at', '<=', $dateTo);
        }

        // Filter payment method
        if ($paymentMethod) {
            $paymentsQuery->where('payment_method', $paymentMethod);
        }

        // Total produk
        $totalCars = Car::where('dealer_id', $dealerId)->count();

        // Total orders
        $totalOrders = Order::whereHas('car', function($q) use ($dealerId, $carId) {
            $q->where('dealer_id', $dealerId);
            if ($carId) $q->where('id', $carId);
        })->count();

        // Total unique customers
        $totalCustomers = Order::whereHas('car', function($q) use ($dealerId, $carId) {
            $q->where('dealer_id', $dealerId);
            if ($carId) $q->where('id', $carId);
        })->distinct('cust_id')->count('cust_id');

        // Total income dari pembayaran
        $totalPaid = (clone $paymentsQuery)->sum('amount');

        // Total pembayaran cash
        $totalCash = (clone $paymentsQuery)->where('payment_method', 'cash')->sum('amount');

        // Total pembayaran DP
        $totalDP = (clone $paymentsQuery)->where('payment_method', 'dp')->sum('amount');

        // Total pembayaran cicilan
        $totalInstallment = (clone $paymentsQuery)->where('payment_method', 'installment')->sum('amount');

        // Recent Payments (7 terakhir, sudah terfilter)
        $recentPayments = (clone $paymentsQuery)->latest()->take(7)->get();

       $recentPaymentActivities = $recentPayments->map(function($pay) {
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

        // Monthly paid (grafik pembayaran masuk)
        $monthlyPaid = [];
        $now = Carbon::now('Asia/Jakarta');
        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($now->year, $m, 1, 0, 0, 0, 'Asia/Jakarta');
            $total = (clone $paymentsQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
            $monthlyPaid[] = [
                'label' => $month->format('M'),
                'total' => $total
            ];
        }

        $dealerUser = Auth::user(); // atau Auth::id() kalau pakai relasi user
        $notifications = $dealerUser->notifications()->latest()->take(10)->get(); // ambil 10 notifikasi terbaru
        $unreadCount = $dealerUser->unreadNotifications()->count();


        $allCars = Car::where('dealer_id', $dealerId)->pluck('car_code', 'id');

        return view('pages.dealer.dashboard', [
            'totalCars'        => $totalCars,
            'totalOrders'      => $totalOrders,
            'totalCustomers'   => $totalCustomers,
            'totalPaid'        => $totalPaid,
            'totalCash'        => $totalCash,
            'totalDP'          => $totalDP,
            'totalInstallment' => $totalInstallment,
            'recentPaymentActivities' => $recentPaymentActivities,
            'monthlyPaid'      => $monthlyPaid,
            'allCars'          => $allCars,
            'filter'           => [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'payment_method' => $paymentMethod,
            'car_id' => $carId,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,

        ],
    ]);
}
}
