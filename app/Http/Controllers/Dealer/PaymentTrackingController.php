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

    // Filter by payment method
    if ($request->filled('method')) {
        $paymentsQuery->where('payment_method', $request->method);
    }

    // Filter by customer name
    if ($request->filled('customer')) {
        $paymentsQuery->whereHas('order.customer.user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->customer . '%');
        });
    }

    // Filter by date range (fix name)
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
