<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller; // <- ini wajib
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('customer.home');
    }
}