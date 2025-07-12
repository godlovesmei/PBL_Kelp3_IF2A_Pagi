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
    // Menampilkan daftar order dengan filter
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

        // Pencarian
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

        // Filter status
        if ($status) {
            $orders->where('order_status', $status);
        }

        // Filter metode pembayaran
        if ($paymentMethod) {
            $orders->whereHas('payments', function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod);
            });
        }

        // Filter berdasarkan tanggal cepat
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

    // Update status order dan kurangi stok jika perlu
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirm,processing,shipped,completed,cancelled',
        ]);

        $newStatus = $validated['status'];

        // Jika status berubah menjadi 'shipped' dan belum pernah dikirim sebelumnya
        if ($newStatus === 'shipped' && $order->order_status !== 'shipped') {
            $car = $order->car;

            if ($car && $car->stock > 0) {
                $car->decrement('stock');
            } else {
                return back()->withErrors('Stok mobil tidak mencukupi untuk mengirim order ini.');
            }
        }

        $order->order_status = $newStatus;
        $order->save();

        return redirect()->route('pages.dealer.order-index', ['status' => $order->order_status])
                         ->with('success', 'Order status updated successfully.');
    }

    // Status checker khusus, bisa disesuaikan logikanya
    public function changeStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $newStatus = $request->input('status');

        if ($newStatus == 'confirm' && $order->order_status == 'pending') {
            $order->order_status = 'confirm';
            $order->save();
            return back()->with('success', 'Order sudah dikonfirmasi.');
        }

        if ($newStatus == 'processing' && $order->order_status == 'confirm') {
            $dpPayment = $order->payments()->where('payment_method', 'down_payment')->first();
            if (!$dpPayment) {
                return back()->withErrors('Belum ada bukti DP dari pembeli.');
            }

            $order->order_status = 'processing';
            $order->save();
            return back()->with('success', 'Status order diubah menjadi Processing.');
        }

        // Tambahan: logic shipped di sini juga kalau pakai route ini
        if ($newStatus == 'shipped' && $order->order_status == 'processing') {
            $car = $order->car;
            if ($car && $car->stock > 0) {
                $car->decrement('stock');
            } else {
                return back()->withErrors('Stok mobil tidak mencukupi untuk dikirim.');
            }

            $order->order_status = 'shipped';
            $order->save();
            return back()->with('success', 'Order telah dikirim.');
        }

        return back()->withErrors('Status tidak valid atau aksi tidak diizinkan.');
    }
}
