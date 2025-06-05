<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    // Tampilkan list order dengan pagination, filter status dan search
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Order::with('car')->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('order_status', $status);
        }

        if ($search) {
    $query->where(function ($q) use ($search) {
        // Cari berdasarkan nama mobil
        $q->whereHas('car', function ($carQuery) use ($search) {
            $carQuery->where('model', 'like', "%{$search}%");
        });

        // Cari berdasarkan nama/email/phone user dari customer
        $q->orWhereHas('customer.user', function ($userQuery) use ($search) {
            $userQuery->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    });
}


        $orders = $query->paginate(10)->withQueryString();

        return view('pages.dealer.order-index', compact('orders', 'status', 'search'));
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
}
