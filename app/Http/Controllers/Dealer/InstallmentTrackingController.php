<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Installment;

class InstallmentTrackingController extends Controller
{
    /**
     * Menampilkan daftar order atau detail cicilan order khusus dealer login.
     */
public function index(Request $request)
{
    $dealerId = Auth::id();

    if ($request->has('order_id')) {
        $order = Order::with(['customer.user', 'car', 'installments.payments'])
            ->whereHas('car', function ($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            })
            ->findOrFail($request->order_id);

        $installments = $order->installments;

        return view('pages.dealer.installments', compact('order', 'installments'));
    }

    $ordersQuery = Order::where('payment_method', 'credit')
        ->whereHas('car', function ($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })
        ->with(['customer.user', 'car']);

    if ($request->filled('customer')) {
        $ordersQuery->whereHas('customer.user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->customer . '%');
        });
    }

    if ($request->filled('status')) {
        $ordersQuery->where('payment_status', $request->status);
    }

    if ($request->filled('date_from')) {
        $ordersQuery->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $ordersQuery->whereDate('created_at', '<=', $request->date_to);
    }

    $orders = $ordersQuery->latest()->paginate(15)->appends($request->except('page'));

    return view('pages.dealer.installments', compact('orders'));
}
}
