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
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'salary_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'car_id' => 'required|exists:cars,id',
            'down_payment' => 'required|numeric|min:30|max:50',
            'payment_method' => 'required|string|in:credit_card,cash',
        ]);

        try {
            // 1. Ambil data mobil yang dibeli
            $car = Car::findOrFail($validated['car_id']);
            $carPrice = $car->price;
            $downPaymentPercentage = $validated['down_payment'];

            // Hitung jumlah down payment dan total harga
            $downPaymentAmount = ($downPaymentPercentage / 100) * $carPrice;
            $totalPrice = $carPrice - $downPaymentAmount;

            // 2. Menyimpan atau memperbarui data User
            $user = User::updateOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'phone' => $validated['phone'],
                ]
            );

            // 3. Menyimpan dokumen (KTP, NPWP, Slip Gaji) ke storage
            $docPaths = [];
            foreach (['ktp', 'npwp', 'salary_slip'] as $file) {
                // Handle file uploads
                $docPaths[$file] = $request->hasFile($file) && $request->file($file)->isValid()
                    ? $request->file($file)->store('documents', 'public')  // Store file path
                    : '';  // If file is missing, store an empty string
            }

            // Menyimpan atau memperbarui data Customer
            $customer = Customer::updateOrCreate(
                ['cust_id' => $user->user_id],
                [
                    'ktp_doc' => $docPaths['ktp'] ?? '',  // Ensure empty string if no file
                    'npwp_doc' => $docPaths['npwp'] ?? '',
                    'salary_doc' => $docPaths['salary_slip'] ?? '',
                ]
            );

            // 5. Menyimpan data Order
            $order = Order::create([
                'car_id' => $car->id,
                'cust_id' => $customer->cust_id,
                'total_price' => $totalPrice,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',  // Assume payment status is 'unpaid'
                'order_status' => 'pending',    // Assume order status is 'pending'
            ]);

            // 6. Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Order submitted successfully!');

        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk memesan mobil (mengisi order).
     *
     * @param int $carId
     * @return \Illuminate\View\View
     */
    public function showOrderForm($carId)
    {
        $car = Car::findOrFail($carId);
        return view('pages.cars.purchase', compact('car'));
    }
}
