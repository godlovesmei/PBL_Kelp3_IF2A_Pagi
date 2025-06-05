<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Car as Mobil;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:dealer');
    }

    /**
     * Tampilkan dashboard dealer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil jumlah mobil yang dijual oleh dealer
        $totalMobil = Mobil::where('dealer_id', Auth::id())->count();

        // Kirim data ke view pages/dealer/dashboard
        return view('pages.dealer.dashboard', [
            'totalMobil' => $totalMobil,
        ]);
    }
}