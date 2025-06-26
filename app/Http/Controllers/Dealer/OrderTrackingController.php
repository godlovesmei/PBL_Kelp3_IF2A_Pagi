<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Car;
use App\Models\Customer;

class OrderTrackingController extends Controller
{
    // List order dengan filter user-friendly dan best practice
    public function index(Request $request)
    {
        $dealerId = Auth::id();

        // Ambil filter dari request
        $search = $request->query('search');
        $status = $request->query('status');
        $paymentMethod = $request->query('payment_method');
        $quickDate = $request->query('quick_date');
        $sort = $request->query('sort', 'created_at_desc');

        $orders = Order::with(['car', 'customer.user', 'payments'])
            ->whereHas('car', function ($q) use ($dealerId) {
                $q->where('dealer_id', $dealerId);
            });

        // Search (order_id, customer name, email, phone)
        if ($search) {
            $orders->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhereHas('customer.user', function ($userQuery) use ($search) {
                      $userQuery->where(function ($sub) use ($search) {
                          $sub->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%")
                              ->orWhere('phone', 'like', "%{$search}%");
                      });
                  });
            });
        }

        // Status
        if ($status) {
            $orders->where('order_status', $status);
        }

        // Payment Method (cek ke relasi payments)
        if ($paymentMethod) {
            $orders->whereHas('payments', function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod);
            });
        }

        // Quick date filter
        if ($quickDate) {
            if ($quickDate === 'today') {
                $orders->whereDate('created_at', now()->toDateString());
            } elseif ($quickDate === '7days') {
                $orders->whereDate('created_at', '>=', now()->subDays(7)->toDateString());
            } elseif ($quickDate === '30days') {
                $orders->whereDate('created_at', '>=', now()->subDays(30)->toDateString());
            }
        }

        // Sorting
        switch ($sort) {
            case 'created_at_asc':
                $orders->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
                $orders->orderBy('created_at', 'desc');
                break;
            default:
                $orders->orderBy('created_at', 'desc');
        }

        $orders = $orders->paginate(10)->withQueryString();

        return view('pages.dealer.order-index', [
            'orders' => $orders,
            'search' => $search,
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'quickDate' => $quickDate,
            'sort' => $sort,
        ]);
    }

    // Update status order dengan validasi dan feedback
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirm,processing,shipped,completed',
        ]);

        $order->order_status = $validated['status'];
        $order->save();

        // Redirect ke halaman filter sesuai status baru agar daftar terupdate otomatis
        return redirect()->route('pages.dealer.order-index', ['status' => $order->order_status])
                         ->with('success', 'Order status updated successfully.');
    }
    public function changeStatus(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);

    // Contoh validasi status
    $newStatus = $request->input('status');

    if ($newStatus == 'confirm' && $order->order_status == 'pending') {
        $order->order_status = 'confirm';
        $order->save();
        return back()->with('success', 'Order sudah di konfirmasi');
    }

    if ($newStatus == 'processing' && $order->order_status == 'confirm') {
        // Pastikan sudah ada pembayaran DP
        $dpPayment = $order->payments()->where('payment_method', 'down_payment')->first();
        if (!$dpPayment) {
            return back()->withErrors('Belum ada bukti DP dari pembeli.');
        }

        $order->order_status = 'processing';
        $order->save();

        return back()->with('success', 'Status order diubah menjadi Processing');
    }

    return back()->withErrors('Status tidak valid atau aksi tidak diizinkan');
}

}
