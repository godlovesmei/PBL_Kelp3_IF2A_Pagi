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
     * Tampilkan daftar order kredit milik dealer atau detail cicilan per order.
     */
public function index(Request $request)
{
    $dealerId = Auth::id();

    // Detail cicilan jika ada order_id
    if ($request->filled('order_id')) {
        $order = Order::with([
                'customer.user',
                'car',
                'installments' => fn ($q) => $q->with('payments')->orderBy('due_date')
            ])
            ->whereHas('car', fn ($q) => $q->where('dealer_id', $dealerId))
            ->findOrFail($request->order_id);

        $installments = $order->installments;

        return view('pages.dealer.installments', compact('order', 'installments'));
    }

    // Ambil recentInstallments di sini
    $recentInstallments = Installment::with(['order.customer.user', 'order.car'])
        ->whereHas('order.car', function($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })
        ->where('status', 'paid')
        ->orderBy('paid_at', 'desc')
        ->take(10)
        ->get();

        $installmentsToConfirm = Installment::with(['order.customer.user', 'order.car'])
    ->whereHas('order.car', function($q) use ($dealerId) {
        $q->where('dealer_id', $dealerId);
    })
    ->whereIn('status', ['waiting_confirmation', 'pending'])
    ->orderBy('due_date', 'asc')
    ->get();

    // Daftar semua order kredit milik dealer
    $ordersQuery = Order::select('orders.*')
        ->selectSub(
            Installment::select('due_date')
                ->whereColumn('installments.order_id', 'orders.order_id')
                ->orderBy('due_date')
                ->limit(1),
            'nearest_due_date'
        )
        ->join('cars', 'orders.car_id', '=', 'cars.id')
        ->where('orders.payment_method', 'credit')
        ->where('cars.dealer_id', $dealerId)
        ->with(['customer.user', 'car']);

    // Filter: status pembayaran
    if ($request->filled('status')) {
        $ordersQuery->where('orders.payment_status', $request->status);
    }

    // Filter: rentang tanggal
    if ($request->filled('date_from')) {
        $ordersQuery->whereDate('orders.created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $ordersQuery->whereDate('orders.created_at', '<=', $request->date_to);
    }

    // Filter: search by Order ID dan Customer
    if ($request->filled('search')) {
        $ordersQuery->where(function ($query) use ($request) {
        $query->where('orders.order_id', 'like', '%' . $request->search . '%')
              ->orWhereHas('customer.user', function ($q) use ($request) {
                  $q->where('name', 'like', '%' . $request->search . '%');
              });
    });
    }

    // Urutan: unpaid -> due soonest, paid -> terbaru
    $orders = $ordersQuery
        ->orderByRaw("CASE WHEN orders.payment_status = 'unpaid' THEN 0 ELSE 1 END")
        ->orderByRaw("CASE WHEN orders.payment_status = 'unpaid' THEN nearest_due_date ELSE NULL END ASC")
        ->orderByRaw("CASE WHEN orders.payment_status = 'paid' THEN orders.created_at ELSE NULL END DESC")
        ->paginate(15)
        ->appends($request->except('page'));

    // KIRIM keduanya ke view
    return view('pages.dealer.installments', compact('orders', 'recentInstallments', 'installmentsToConfirm'));
}

    /**
     * Konfirmasi pembayaran cicilan oleh dealer.
     */
    public function confirm($installmentId)
    {
        $installment = Installment::findOrFail($installmentId);

        if (!in_array($installment->status, ['pending', 'waiting_confirmation'])) {
            return back()->with('error', 'Installment cannot be confirmed at this stage.');
        }

        $installment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Installment has been confirmed as paid.');
    }

    /**
     * Tolak pembayaran cicilan oleh dealer.
     */
    public function reject($installmentId)
    {
        $installment = Installment::findOrFail($installmentId);

        if (!in_array($installment->status, ['pending', 'waiting_confirmation'])) {
            return back()->with('error', 'Installment cannot be rejected at this stage.');
        }

        $installment->update([
            'status' => 'rejected',
        ]);

        return back()->with('error', 'Installment payment has been rejected.');
    }
}
