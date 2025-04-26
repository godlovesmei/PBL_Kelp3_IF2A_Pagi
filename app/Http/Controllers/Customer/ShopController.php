<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;

class ShopController extends Controller
{
    public function index()
    {
        $cars = Car::with('colors')->get(); // Ambil semua mobil beserta warnanya

        return view('customer.shop', compact('cars'));
    }
}

