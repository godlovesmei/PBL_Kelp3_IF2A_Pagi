<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Car as Mobil;
use Illuminate\Support\Facades\Redirect;
use App\Constants\RoleConstant;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dealer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Periksa apakah user memiliki role 'dealer'
        if (Auth::user()->role_id !== RoleConstant::DEALER) {
            // Redirect jika bukan dealer
            return redirect()->route('pages.home')->with('error', 'You do not have permission to access the dealer dashboard.');
        }

        // Ambil jumlah mobil yang dijual oleh dealer
        $totalMobil = Mobil::where('dealer_id', Auth::id())->count();

        // Kirim data ke view pages/dealer/dashboard
        return view('pages.dealer.dashboard', [
            'totalMobil' => $totalMobil,
        ]);
    }
}
