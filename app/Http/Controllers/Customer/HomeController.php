<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user(); // bisa null kalau belum login
        return view('customer.home', compact('user'));
    }
}