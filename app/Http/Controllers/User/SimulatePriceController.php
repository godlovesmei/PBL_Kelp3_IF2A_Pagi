<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class SimulatePriceController extends Controller
{
    public function simulate(Request $request, $id)
    {
        $dpPercent = (int)$request->input('dp', 30);
        $car = Car::with(['dealer', 'colors'])->findOrFail($id);

        // Kalkulasi (bisa disesuaikan sesuai kebutuhan bisnis)
        $price = $car->price;
        $dpAmount = round($price * $dpPercent / 100);
        $insurance = round($price * 0.02); // Contoh 2%
        $adminFees = [1246000, 1296000, 1346000, 1396000, 1666000];
        $tenors = [1, 2, 3, 4, 5];
        $installments = [];
        $totals = [];

        foreach ($tenors as $i => $tenor) {
            $principal = $price - $dpAmount;
            $interest = $principal * 0.05 * $tenor;
            $totalCredit = $principal + $interest;
            $installment = $totalCredit / ($tenor * 12);
            $installments[] = round($installment);
            $total = $dpAmount + ($installment * $tenor * 12) + $insurance + $adminFees[$i];
            $totals[] = round($total);
        }

        return response()->json([
            'dpAmount' => $dpAmount,
            'installments' => $installments,
            'admin' => $adminFees,
            'insurance' => $insurance,
            'total' => $totals,
            // Bisa tambahkan info mobil, dealer, warna, dll kalau mau
        ]);
    }
}