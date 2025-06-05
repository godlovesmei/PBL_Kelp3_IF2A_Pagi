<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    /**
     * Handle the purchase form submission.
     */
    public function submit(Request $request)
{
    // Validasi
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'salary_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'car_id' => 'required|exists:cars,id',
        'payment_method' => 'required|string|in:credit,cash',
        // DP dan tenor hanya wajib jika kredit
        'tenor' => 'nullable|integer|in:12,24,36,48,60',
        'down_payment_percent' => 'nullable|numeric|min:30|max:50',
        'down_payment' => 'nullable|numeric|min:1',
    ]);

    try {
        $car = Car::findOrFail($validated['car_id']);
        $carPrice = $car->price;

        // Siapkan variabel default
        $downPaymentPercent = null;
        $downPaymentAmount = null;
        $amountFinanced = null;
        $tenor = null;
        $monthlyInstallment = null;

        if ($validated['payment_method'] === 'credit') {
            // Pastikan field kredit wajib diisi
            $request->validate([
                'tenor' => 'required|integer|in:12,24,36,48,60',
                'down_payment_percent' => 'required|numeric|min:30|max:50',
                'down_payment' => 'required|numeric|min:1',
            ]);
            $downPaymentPercent = $validated['down_payment_percent'];
            $downPaymentAmount = $validated['down_payment'];

            // Validasi DP nominal sesuai persen
            $expectedDownPayment = floor($carPrice * $downPaymentPercent / 100);
            if (abs($downPaymentAmount - $expectedDownPayment) > 1000) {
                return back()->withErrors(['down_payment' => 'Down payment nominal tidak sesuai persentase.'])->withInput();
            }

            $amountFinanced = $carPrice - $downPaymentAmount;
            $tenor = $validated['tenor'];
            // Simulasi angsuran flat 0.5% per bulan
            $interestRatePerMonth = 0.005;
            $totalInterest = $amountFinanced * $interestRatePerMonth * $tenor;
            $totalLoan = $amountFinanced + $totalInterest;
            $monthlyInstallment = round($totalLoan / $tenor);
        }

        // Simpan/update User
        $user = User::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
            ]
        );

        // Simpan dokumen
        $docPaths = [];
        foreach (['ktp', 'npwp', 'salary_slip'] as $file) {
            $docPaths[$file] = ($request->hasFile($file) && $request->file($file)->isValid())
                ? $request->file($file)->store('documents', 'public')
                : '';
        }

        // Simpan/update Customer (asumsi relasi: user_id = cust_id)
        $customer = Customer::updateOrCreate(
            ['cust_id' => $user->user_id],
            [
                'ktp_doc' => $docPaths['ktp'],
                'npwp_doc' => $docPaths['npwp'],
                'salary_doc' => $docPaths['salary_slip'],
            ]
        );

        // Simpan Order
        $order = Order::create([
            'car_id' => $car->id,
            'cust_id' => $customer->cust_id,
            'total_price' => $carPrice,
            'down_payment' => $downPaymentAmount,
            'down_payment_percent' => $downPaymentPercent,
            'amount_financed' => $amountFinanced,
            'tenor' => $tenor,
            'monthly_installment' => $monthlyInstallment,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
        ]);

        return redirect()->back()->with([
            'success' => 'Terima kasih telah mempercayai kami untuk pembelian mobil Anda. Pesanan Anda akan diproses dalam 3-7 hari kerja. Kami akan segera menghubungi Anda untuk informasi lebih lanjut.',
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Menampilkan form pemesanan mobil.
     */
    public function showOrderForm($carId)
    {
        $car = Car::findOrFail($carId);
        $carPrice = $car->price;
        return view('pages.cars.purchase', compact('car', 'carPrice'));
    }
}
