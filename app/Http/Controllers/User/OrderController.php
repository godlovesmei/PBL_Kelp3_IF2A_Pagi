<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Installment;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('cust_id', $user->user_id)->with('user')->first();

        $orders = $customer
            ? Order::where('cust_id', $customer->cust_id)
                ->with('car')
                ->latest()
                ->paginate(10)
            : collect();

        return view('pages.user.order', compact('orders', 'customer'));
    }

    public function show($orderId)
    {
        $user = Auth::user();
        $customer = Customer::where('cust_id', $user->user_id)->with('user')->firstOrFail();
        $order = Order::where('order_id', $orderId)
            ->where('cust_id', $customer->cust_id)
            ->with('car')
            ->firstOrFail();

        // Ambil pembayaran cash (langsung lunas)
        $cashPayment = Payment::where('order_id', $order->order_id)
            ->where('payment_method', 'cash')
            ->first();

        // Ambil pembayaran DP (credit)
        $dpPayment = Payment::where('order_id', $order->order_id)
            ->where('payment_method', 'dp')
            ->first();

        // Ambil daftar installments (jika kredit)
        $installments = Installment::where('order_id', $order->order_id)
            ->with('payments')
            ->orderBy('due_date')
            ->get();

        return view('pages.user.order-show', compact('order', 'customer', 'cashPayment', 'dpPayment', 'installments'));
    }

    /**
     * Upload pembayaran cash (jika cash).
     */
    public function uploadCash(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'amount' => 'required|numeric|min:10000',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $order = Order::findOrFail($request->order_id);

        $path = $request->file('payment_proof')->store('uploads/bukti_cash', 'public');

        Payment::create([
            'order_id' => $order->order_id,
            'installment_id' => null,
            'amount' => $request->amount,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'payment_proof' => $path,
        ]);

        // Jika lunas, update status order
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        return back()->with('success', 'Cash payment proof uploaded successfully.');
    }

    /**
     * Upload pembayaran DP (jika kredit).
     */
    public function uploadDP(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'amount' => 'required|numeric|min:10000',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $order = Order::findOrFail($request->order_id);

        $path = $request->file('payment_proof')->store('uploads/bukti_dp', 'public');

        Payment::create([
            'order_id' => $order->order_id,
            'installment_id' => null,
            'amount' => $request->amount,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'dp',
            'payment_proof' => $path,
        ]);

        // Update status order ke processing
        $order->update([
            'order_status' => 'processing',
        ]);

        return back()->with('success', 'Down payment proof uploaded successfully.');
    }

    /**
     * Upload pembayaran cicilan bulanan (jika kredit).
     */
    public function uploadInstallment(Request $request)
    {
        $request->validate([
            'order_id'       => 'required|exists:orders,order_id',
            'installment_id' => 'required|exists:installments,installment_id',
            'amount'         => 'required|numeric|min:10000',
            'payment_proof'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $installment = Installment::findOrFail($request->installment_id);
        $order = Order::findOrFail($request->order_id);

        $path = $request->file('payment_proof')->store('uploads/cicilan', 'public');

        Payment::create([
            'order_id'       => $order->order_id,
            'installment_id' => $installment->installment_id,
            'amount'         => $request->amount,
            'payment_date'   => now()->toDateString(),
            'payment_method' => 'installment',
            'payment_proof'  => $path,
        ]);

        // Update installment jika sudah lunas
        if ($request->amount >= $installment->amount) {
            $installment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        // Cek jika semua installment sudah paid
        $unpaidCount = Installment::where('order_id', $order->order_id)->where('status', 'unpaid')->count();
        if ($unpaidCount == 0) {
            $order->update([
                'payment_status' => 'paid',
            ]);
        }

        return back()->with('success', 'Installment payment proof uploaded successfully.');
    }
    public function downloadInvoice(Request $request, $order_id)
{
    $type = $request->type; // 'dp', 'cash', atau 'installment'
    $order = Order::with(['car', 'customer.user'])->findOrFail($order_id);
    $payment = null;
    $installment = null;

    if ($type === 'dp') {
    $payment = $order->payments()->where('payment_method', 'dp')->first();
} elseif ($type === 'cash') {
    $payment = $order->payments()->where('payment_method', 'cash')->first();
} elseif ($type === 'installment') {
    $installment_id = $request->installment_id;
    $installment = Installment::where('order_id', $order->order_id)
        ->with('payments')
        ->where('installment_id', $installment_id)
        ->firstOrFail();

    $payment = $installment->payments->first();
}


$pdf = Pdf::loadView('pages.user.invoice', compact('order', 'type', 'payment', 'installment'));
    return $pdf->download("invoice_{$type}order{$order_id}.pdf");
}
}
