<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    // Menampilkan detail mobil berdasarkan ID
    public function show($id)
    {
        // Ambil mobil beserta warna-warna dan galeri
        $car = Car::with(['colors', 'galleries'])->findOrFail($id);

        // Kelompokkan galleries berdasarkan type
        $exteriorGalleries = $car->galleries->where('type', 'eksterior')->values();
        $interiorGalleries = $car->galleries->where('type', 'interior')->values();

        // (opsional) Ambil warna default (warna pertama)
        $defaultColor = $car->colors->first();

        // Kirim data ke view
        return view('pages.car-details', [
            'car' => $car,
            'exteriorGalleries' => $exteriorGalleries,
            'interiorGalleries' => $interiorGalleries,
            'defaultColor' => $defaultColor,
        ]);
    }
}
