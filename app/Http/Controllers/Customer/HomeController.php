<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user(); // bisa null kalau belum login
        $popularCars = Car::where('model', 'like', '%Civic%')->get();
    
        return view('pages.home', compact('user', 'popularCars'));
    }
}