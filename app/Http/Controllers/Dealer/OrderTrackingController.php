<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    // List order dengan filter lebih lengkap dan best practice
    public function index(Request $request)
    {
        $dealerId = Auth::id();
        $status = $request->query('status');
        $search = $request->query('search');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $paymentMethod = $request->query('payment_method');
        $carType = $request->query('car_type');
        $customerId = $request->query('customer_id');
        $sort = $request->query('sort', 'created_at_desc');

        $query = Order::with(['car', 'customer.user', 'payments'])
            ->whereHas('car', function ($q) use ($dealerId, $carType) {
                $q->where('dealer_id', $dealerId);
                if ($carType) $q->where('type', $carType);
            });

        // Filter status
        if ($status) {
            $query->where('order_status', $status);
        }

        // Filter range tanggal order
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Filter customer
        if ($customerId) {
            $query->where('cust_id', $customerId);
        }

        // Filter metode pembayaran (cek payments relasi)
        if ($paymentMethod) {
            $query->whereHas('payments', function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod);
            });
        }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('car', function ($carQuery) use ($search) {
                    $carQuery->where('model', 'like', "%{$search}%");
                })
                ->orWhereHas('customer.user', function ($userQuery) use ($search) {
                    $userQuery->where(function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                });
            });
        }

        // Sorting
        switch ($sort) {
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'customer_asc':
                $query->orderBy(
                    Order::select('name')
                        ->join('customers', 'orders.cust_id', '=', 'customers.cust_id')
                        ->join('users', 'customers.cust_id', '=', 'users.user_id')
                        ->whereColumn('orders.cust_id', 'customers.cust_id')
                        ->orderBy('users.name', 'asc')
                        ->limit(1)
                );
                break;
            case 'customer_desc':
                $query->orderBy(
                    Order::select('name')
                        ->join('customers', 'orders.cust_id', '=', 'customers.cust_id')
                        ->join('users', 'customers.cust_id', '=', 'users.user_id')
                        ->whereColumn('orders.cust_id', 'customers.cust_id')
                        ->orderBy('users.name', 'desc')
                        ->limit(1)
                );
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Validasi filter (misal: status)
        if ($status && !in_array($status, ['pending', 'confirm', 'processing', 'shipped', 'completed'])) {
            return back()->withErrors('Status filter tidak valid.');
        }

        $orders = $query->paginate(10)->withQueryString();

        // Untuk kebutuhan dropdown di view (filter)
        $allCustomers = Order::whereHas('car', function ($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })->with('customer.user')->get()->pluck('customer.user.name', 'cust_id')->unique();

        $allCarTypes = Order::whereHas('car', function ($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId);
        })->with('car')->get()->pluck('car.type')->unique();

        return view('pages.dealer.order-index', compact(
            'orders', 'status', 'search', 'dateFrom', 'dateTo', 'paymentMethod', 'carType', 'customerId', 'sort',
            'allCustomers', 'allCarTypes'
        ));
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
