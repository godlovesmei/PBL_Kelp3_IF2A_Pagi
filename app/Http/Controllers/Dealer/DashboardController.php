<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil; // Model untuk data mobil
use App\Models\Order; // Model untuk data pesanan
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dealer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil jumlah mobil yang dijual oleh dealer
        $totalMobil = Mobil::where('dealer_id', Auth::id())->count();

        // Ambil jumlah pesanan untuk dealer
        $totalPesanan = Order::where('dealer_id', Auth::id())->count();

        // Kirim data ke view dealer.dashboard
        return view('dealer.dashboard', [
            'totalMobil' => $totalMobil,
            'totalPesanan' => $totalPesanan,
        ]);
    }
}