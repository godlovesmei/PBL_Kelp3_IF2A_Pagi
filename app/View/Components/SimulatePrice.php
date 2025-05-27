<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Car;

class SimulatePrice extends Component
{
    public $car;

    /**
     * Create a new component instance.
     *
     * @param  Car  $car
     * @return void
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Get simulation data for a given DP percent.
     */
    public function getSimulationData($dpPercent)
    {
        $price = $this->car->price;
        $dpAmount = round($price * $dpPercent / 100);

        // Simulasi perhitungan kredit (bisa disesuaikan dengan formula bisnis)
        $insurance = round($price * 0.02); // contoh 2% dari harga mobil
        $adminFees = [1246000, 1296000, 1346000, 1396000, 1666000]; // admin fee per tenor tahun
        $tenors = [1, 2, 3, 4, 5];
        $installments = [];
        $totals = [];

        foreach ($tenors as $i => $tenor) {
            $principal = $price - $dpAmount;
            $interest = $principal * 0.05 * $tenor; // bunga flat 5% per tahun (contoh)
            $totalCredit = $principal + $interest;
            $installment = $totalCredit / ($tenor * 12);
            $installments[] = round($installment);
            $total = $dpAmount + ($installment * $tenor * 12) + $insurance + $adminFees[$i];
            $totals[] = round($total);
        }

        return [
            'dpAmount' => $dpAmount,
            'installments' => $installments,
            'admin' => $adminFees,
            'insurance' => $insurance,
            'total' => $totals,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.simulate-price');
    }
}