<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class SimulatePriceController extends Controller
{
    public function simulate(Request $request, $id)
    {
        // Validasi DP persentase (antara 30-70%)
        $validated = $request->validate([
            'dp' => 'required|integer|min:30|max:70',
        ]);

        $dpPercent = $validated['dp'];
        $car = Car::with(['dealer', 'colors'])->findOrFail($id);
        $price = $car->price;

        // Komponen biaya
        $dpAmount = round($price * $dpPercent / 100);
        $insurance = round($price * 0.02); // 2% dari harga mobil
        $adminFees = [1246000, 1296000, 1346000, 1396000, 1666000];
        $tenors = [1, 2, 3, 4, 5];

        $installments = [];
        $totals = [];

        foreach ($tenors as $i => $tenor) {
            $principal = $price - $dpAmount;
            $interest = $principal * 0.05 * $tenor; // Bunga efektif 5% per tahun
            $totalCredit = $principal + $interest;

            $monthlyInstallment = $totalCredit / ($tenor * 12);
            $totalPayment = $dpAmount + ($monthlyInstallment * $tenor * 12) + $insurance + $adminFees[$i];

            $installments[] = round($monthlyInstallment);
            $totals[] = round($totalPayment);
        }

        return response()->json([
            'dpAmount' => $dpAmount,
            'installments' => $installments,
            'admin' => $adminFees,
            'insurance' => $insurance,
            'total' => $totals,
        ]);
    }
}
