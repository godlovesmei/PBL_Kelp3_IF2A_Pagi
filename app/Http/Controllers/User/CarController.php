<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    // Menampilkan detail mobil berdasarkan ID
    public function show($id)
    {
        // Ambil mobil beserta warna-warnanya
        $car = Car::with('colors')->findOrFail($id);

        // Ambil warna default (warna pertama dalam daftar)
        $defaultColor = $car->colors->first();

        return view('pages.car-details', compact('car', 'defaultColor'));
    }
}