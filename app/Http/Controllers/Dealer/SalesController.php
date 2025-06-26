<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $dealerId = Auth::id();

        // --- Filter (optional) ---
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $carId = $request->input('car_id');

        $ordersQuery = Order::with(['car', 'customer.user', 'payments'])
            ->whereHas('car', function($q) use ($dealerId, $carId) {
                $q->where('dealer_id', $dealerId);
                if ($carId) $q->where('id', $carId);
            });

        if ($dateFrom) {
            $ordersQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $ordersQuery->whereDate('created_at', '<=', $dateTo);
        }

        $orders = (clone $ordersQuery)->get();

        // --- Stats ---
        $totalUnitsSold = $orders->count();
        $totalSalesValue = $orders->flatMap->payments->sum('amount'); // Sum all payments from orders

        // --- Sales per Car Model ---
        $salesPerModel = $orders->groupBy(function ($order) {
            return $order->car->model ?? '-';
        })->map(function ($group, $model) {
            $totalUnit = $group->count();
            $totalAmount = $group->flatMap->payments->sum('amount');
            return [
                'model' => $model,
                'units_sold' => $totalUnit,
                'total_sales' => $totalAmount,
            ];
        })->sortByDesc('units_sold')->values()->toArray();

        // --- Monthly Sales Trend ---
        $now = Carbon::now('Asia/Jakarta');
        $monthlySales = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($now->year, $m, 1, 0, 0, 0, 'Asia/Jakarta');
            $monthlyOrders = (clone $ordersQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $m)
                ->get();
            $monthlySales[] = [
                'label' => $month->format('M'),
                'units_sold' => $monthlyOrders->count(),
                'total_sales' => $monthlyOrders->flatMap->payments->sum('amount'),
            ];
        }
        // --- Cumulative Sales for the Current Year ---
$cumulativeUnits = 0;
$cumulativeSales = 0;
$cumulativeMonthlySales = [];
foreach ($monthlySales as $month) {
    $cumulativeUnits += $month['units_sold'];
    $cumulativeSales += $month['total_sales'];
    $cumulativeMonthlySales[] = [
        'label' => $month['label'],
        'cumulative_units' => $cumulativeUnits,
        'cumulative_sales' => $cumulativeSales,
        'cumulative_monthly_sales' => $cumulativeUnits > 0 ? round($cumulativeSales / $cumulativeUnits, 2) : 0,
    ];
}

        // --- Filter data untuk dropdown ---
        $allCars = Car::where('dealer_id', $dealerId)->pluck('model', 'id');

        return view('pages.dealer.sales', [
            'totalUnitsSold'   => $totalUnitsSold,
            'totalSalesValue'  => $totalSalesValue,
            'salesPerModel'    => $salesPerModel,
            'monthlySales'     => $monthlySales,
            'cumulativeMonthlySales' => $cumulativeMonthlySales,
            'allCars'          => $allCars,
            'filter'           => [
            'date_from' => $dateFrom,
            'date_to'   => $dateTo,
            'car_id'    => $carId,
            ],
        ]);
    }
}
