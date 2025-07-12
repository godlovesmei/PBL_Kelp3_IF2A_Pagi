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
    /**
     * Show list of user orders with optional status filter and search.
     */
    public function index(Request $request)
    {
        // 1. Definisikan status di controller, bukan di view.
        $statuses = [
            ''           => 'Semua',
            'pending'    => 'Belum Bayar',
            'processing' => 'Sedang Diproses',
            'shipped'    => 'Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];

        // 2. Ambil user yang sedang login.
        $user = Auth::user();

        // 3. Ambil customer ID dari user.
        // Asumsi: Ada relasi one-to-one dari User ke Customer.
        // Jika tidak ada, query Anda sebelumnya sudah benar.
        $customerId = $user->customer->cust_id ?? null;

        // Jika user tidak memiliki data customer, langsung kembalikan view dengan koleksi kosong.
        if (!$customerId) {
            $orders = collect(); // Membuat koleksi kosong
            return view('pages.user.order', compact('orders', 'statuses'));
        }

        // 4. Buat query untuk mengambil order.
        $query = Order::where('cust_id', $customerId)
            ->with('car') // Eager load relasi 'car' untuk performa
            ->latest();   // Urutkan dari yang terbaru

        // 5. Tambahkan logika untuk FILTER STATUS
        // Menggunakan kolom 'order_status' sesuai yang ada di view.
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // 6. Tambahkan logika untuk PENCARIAN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan Order ID
                $q->where('order_id', 'like', "%{$search}%")
                  // Atau cari berdasarkan data di relasi 'car'
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('brand', 'like', "%{$search}%")
                               ->orWhere('model', 'like', "%{$search}%")
                               ->orWhere('car_code', 'like', "%{$search}%");
                  });
            });
        }

        // 7. Eksekusi query dengan paginasi
        // `appends` digunakan agar parameter filter & search tetap ada saat pindah halaman.
        $orders = $query->paginate(10)->appends($request->query());

        // 8. Kirim semua data yang dibutuhkan ke view.
        return view('pages.user.order', compact('orders', 'statuses'));
    }

    /**
     * Show order detail.
     */
public function show($orderId)
{
    $user = Auth::user();
    $customer = Customer::where('cust_id', $user->user_id)->with('user')->firstOrFail();
    $order = Order::where('order_id', $orderId)
        ->where('cust_id', $customer->cust_id)
        ->with('car')
        ->firstOrFail();

    $cashPayment = Payment::where('order_id', $order->order_id)
        ->where('payment_method', 'cash')->first();

    $dpPayment = Payment::where('order_id', $order->order_id)
        ->where('payment_method', 'dp')->first();

    $installments = Installment::where('order_id', $order->order_id)
        ->with('payments')->orderBy('due_date')->get();

    // --- Tambahkan ini: mapping step => tanggal ---
    $stepDates = [
        'pending'    => $order->created_at,
        'confirmed'  => $order->confirmed_at,
        'processing' => $order->processing_at ?? null,
        'financing'  => $order->financing_at ?? null,
        'contract'   => $order->contract_at ?? null,
        'shipped'    => $order->shipped_at ?? null,
        'completed'  => $order->completed_at ?? null,
    ];

    return view('pages.user.order-show', compact(
        'order', 'customer', 'cashPayment', 'dpPayment', 'installments', 'stepDates'
    ));
}

    /**
     * Upload cash payment proof.
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

        // Update order status
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        return back()->with('success', 'Cash payment proof uploaded successfully.');
    }

    /**
     * Upload down payment (DP) proof.
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

        return back()->with('success', 'Down payment proof uploaded successfully.');
    }

    /**
     * Upload installment payment proof.
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

    // FIX: Allow upload proof for both 'unpaid' and 'rejected' installments
    if (in_array($installment->status, ['unpaid', 'rejected'])) {
        $installment->update([
            'status' => 'waiting_confirmation',
        ]);
    }

    // Cek jika semua installment sudah paid, update status order
    $unpaidCount = Installment::where('order_id', $order->order_id)
        ->where('status', 'unpaid')->count();
    if ($unpaidCount == 0) {
        $order->update([
            'payment_status' => 'paid',
        ]);
    }

    return back()->with('success', 'Installment payment proof uploaded successfully.');
}

    /**
     * Download invoice for cash, dp, or installment.
     */
    public function downloadInvoice(Request $request, $order_id)
    {
        $type = $request->type; // 'dp', 'cash', or 'installment'
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

    /**
     * Download recap invoice (all installments and DP).
     */
    public function downloadInvoiceRecap($order_id)
    {
        $order = Order::with(['car', 'customer.user'])->findOrFail($order_id);

        // Get DP payment if exists
        $dpPayment = $order->payments()->where('payment_method', 'dp')->first();

        // Get all installments that have payment(s)
        $installments = Installment::where('order_id', $order->order_id)
            ->whereHas('payments')
            ->with(['payments' => function ($query) {
                $query->orderBy('payment_date');
            }])
            ->orderBy('due_date', 'asc')
            ->get();

        // Generate recap PDF
        $pdf = Pdf::loadView('pages.user.invoice-recap', compact('order', 'dpPayment', 'installments'));
        return $pdf->download("invoice_recap_order{$order_id}.pdf");
    }
}
