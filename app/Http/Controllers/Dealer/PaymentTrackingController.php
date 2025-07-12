<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Installment;

class PaymentTrackingController extends Controller
{
    /**
     * Menampilkan semua riwayat pembayaran (cash, dp, installment) milik dealer login.
     */
public function index(Request $request)
{
    $dealerId = Auth::id();

    $paymentsQuery = Payment::with(['order.car', 'order.customer.user', 'installment'])
        ->whereHas('order.car', function ($query) use ($dealerId) {
            $query->where('dealer_id', $dealerId);
        });

    // Filter: payment method
    if ($request->filled('method')) {
        $paymentsQuery->where('payment_method', $request->method);
    }

// Filter: general keyword (customer name, car code, order ID)
if ($request->filled('search')) {
    $search = strtolower($request->search);

    $paymentsQuery->where(function ($query) use ($search) {
        $query->whereHas('order.customer.user', function ($q) use ($search) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        })
        ->orWhereHas('order.car', function ($q) use ($search) {
            $q->whereRaw('LOWER(car_code) LIKE ?', ["%{$search}%"]);
        })
        ->orWhereHas('order', function ($q) use ($search) {
            $q->where('order_id', 'like', "%{$search}%");
        });
    });
}


    // Filter: date range
    if ($request->filled('from')) {
        $paymentsQuery->whereDate('payment_date', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $paymentsQuery->whereDate('payment_date', '<=', $request->to);
    }

    $payments = $paymentsQuery->latest('payment_date')->paginate(30)->appends($request->except('page'));

    return view('pages.dealer.payments', compact('payments'));
}
}
