<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Installment;
use Illuminate\Support\Facades\Storage;
use App\Notifications\OrderSubmitted;
use App\Notifications\NewOrderForDealer;

class PurchaseController extends Controller
{
    /**
     * Handle the purchase form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'salary' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'car_id' => 'required|exists:cars,id',
            'payment_method' => 'required|string|in:credit,cash',
            'tenor' => 'nullable|integer|in:12,24,36,48,60',
            'down_payment_percent' => 'nullable|numeric|min:30|max:70',
            'down_payment' => 'nullable|numeric|min:1',
        ]);

        try {
            $car = Car::findOrFail($validated['car_id']);
            $carPrice = $car->price;

            $downPaymentPercent = null;
            $downPaymentAmount = null;
            $amountFinanced = null;
            $tenor = null;
            $monthlyInstallment = null;

            if ($validated['payment_method'] === 'credit') {
                $request->validate([
                    'tenor' => 'required|integer|in:12,24,36,48,60',
                    'down_payment_percent' => 'required|numeric|min:30|max:70',
                    'down_payment' => 'required|numeric|min:1',
                ]);

                $downPaymentPercent = $validated['down_payment_percent'];
                $downPaymentAmount = $validated['down_payment'];

                $expectedDownPayment = floor($carPrice * $downPaymentPercent / 100);
                if (abs($downPaymentAmount - $expectedDownPayment) > 1000) {
                    return back()->withErrors(['down_payment' => 'Down payment nominal tidak sesuai persentase.'])->withInput();
                }

                $amountFinanced = $carPrice - $downPaymentAmount;
                $tenor = $validated['tenor'];
                $interestRatePerMonth = 0.005;
                $totalInterest = $amountFinanced * $interestRatePerMonth * $tenor;
                $totalLoan = $amountFinanced + $totalInterest;
                $monthlyInstallment = round($totalLoan / $tenor);
            } else {
                $downPaymentAmount = $carPrice;
                $amountFinanced = 0;
                $tenor = null;
                $monthlyInstallment = null;
            }

            $user = User::updateOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'phone' => $validated['phone'],
                ]
            );

            $docPaths = [];
            foreach (['ktp', 'npwp', 'salary'] as $file) {
                $docPaths[$file] = ($request->hasFile($file) && $request->file($file)->isValid())
                    ? $request->file($file)->store('documents', 'public')
                    : '';
            }

            $customer = Customer::updateOrCreate(
                ['cust_id' => $user->user_id],
                [
                    'ktp_doc' => $docPaths['ktp'],
                    'npwp_doc' => $docPaths['npwp'],
                    'salary_doc' => $docPaths['salary'],
                ]
            );

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

            if ($validated['payment_method'] === 'credit') {
                for ($i = 1; $i <= $tenor; $i++) {
                    Installment::create([
                        'order_id' => $order->order_id,
                        'due_date' => now()->addMonths($i),
                        'amount' => $monthlyInstallment,
                        'status' => 'unpaid',
                        'paid_at' => null,
                    ]);
                }
            }
            // Kirim notifikasi ke dealer
            $dealer = $car->dealer;
            if ($dealer && method_exists($dealer, 'notify')) {
                $dealer->notify(new NewOrderForDealer($order));
            }

    // Kirim notifikasi ke customer
    if (method_exists($user, 'notify')) {
        $user->notify(new OrderSubmitted($order));
    }

            return redirect()->back()->with('success', true);
        } catch (\Exception $e) {
            \Log::error('Order submission error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage()]);
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
