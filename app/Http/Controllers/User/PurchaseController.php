<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Car;
use App\Models\User;
use App\Models\Customer;

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
            'fullname' => 'required',
            'id_number' => 'required',
            'address' => 'required',
            'wa_number' => 'required',
            'email' => 'required|email',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // 'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Hapus jika tidak ada di form
            'salary_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'car_id' => 'required|exists:cars,id',
            'down_payment' => 'required|numeric|min:30|max:50',
            'payment_method' => 'required'
        ]);

        try {
            // 1. Simpan/update data user
            $user = User::updateOrCreate(
                ['id_number' => $validated['id_number']],
                [
                    'name' => $validated['fullname'],
                    'address' => $validated['address'],
                    'whatsapp' => $validated['wa_number'],
                    'email' => $validated['email'],
                ]
            );

            // 2. Simpan dokumen
            $docPaths = [];
            foreach (['ktp', 'npwp', 'salary_slip'] as $file) {
                if ($request->hasFile($file)) {
                    $docPaths[$file] = $request->file($file)->store('documents', 'public');
                }
            }

            // 3. Simpan/update customer data
            $customer = Customer::updateOrCreate(
                ['cust_id' => $user->id],
                [
                    'salary_doc' => $docPaths['salary_slip'] ?? null,
                    'ktp_doc' => $docPaths['ktp'] ?? null,
                    'npwp_doc' => $docPaths['npwp'] ?? null,
                ]
            );

            // 4. Ambil harga mobil dan hitung total harga
            $car = Car::findOrFail($validated['car_id']);
            $carPrice = $car->price;
            $downPaymentPercentage = $validated['down_payment'];

            // Hitung jumlah down payment dan total harga
            $downPaymentAmount = ($downPaymentPercentage / 100) * $carPrice;
            $totalPrice = $carPrice - $downPaymentAmount;

            // 5. Simpan order
            $order = Order::create([
                'car_id' => $car->id,
                'cust_id' => $customer->cust_id,
                'total_price' => $totalPrice,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending'
            ]);

            // Kembalikan response sukses
            return redirect()->back()->with('success', 'Order submitted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}