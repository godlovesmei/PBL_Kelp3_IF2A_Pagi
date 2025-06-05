<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dapatkan customer dengan relasi user sekaligus
        $customer = Customer::where('cust_id', $user->user_id)->with('user')->first();

        $orders = $customer
            ? Order::where('cust_id', $customer->cust_id)->with('car')->latest()->get()
            : collect();

        return view('pages.user.order', compact('orders', 'customer'));
    }

    public function show($orderId)
    {
        $user = Auth::user();

        // Customer dengan relasi user
        $customer = Customer::where('cust_id', $user->user_id)->with('user')->firstOrFail();

        $order = Order::where('order_id', $orderId)
            ->where('cust_id', $customer->cust_id)
            ->with('car')
            ->firstOrFail();

        return view('pages.user.order_show', compact('order', 'customer'));
    }
}

