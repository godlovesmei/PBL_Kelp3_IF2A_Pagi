<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\Mobil;

class DealerController extends Controller
{
    public function index()
    {
        $total_mobil = Mobil::count();
        $total_dealer = Dealer::count();
        $dealers = Dealer::with('mobil')->get(); 

        return view('dealer.dashboard', compact('total_mobil', 'total_dealer', 'dealers'));
    }
}
