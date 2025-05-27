<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Fungsi untuk menampilkan daftar mobil berdasarkan filter
    public function index(Request $request)
    {
        $cars = $this->applyFilters($request)->paginate(12); // Pagination: 12 mobil per halaman
        $categories = Car::select('category')->distinct()->pluck('category'); // Kategori unik

        return view('pages.shop', compact('cars', 'categories'));
    }

    // Fungsi untuk menampilkan detail mobil berdasarkan ID
    public function show($id)
{
    $car = Car::with('colors')->findOrFail($id);
    $carPrice = $car->price; // <-- TAMBAH BARIS INI
    return view('pages.car-details', compact('car', 'carPrice')); // <-- TAMBAHKAN $carPrice
}

    // Fungsi private untuk menyaring mobil berdasarkan filter
    private function applyFilters(Request $request)
    {
        return Car::with('colors')
            ->when($request->input('category'), function ($query, $categories) {
                $query->whereIn('category', $categories); // Filter kategori
            })
            ->when($request->input('price'), function ($query, $prices) {
                $query->where(function ($q) use ($prices) {
                    foreach ($prices as $price) {
                        if ($price == '<300') {
                            $q->orWhere('price', '<', 300000000);
                        } elseif ($price == '>300') {
                            $q->orWhere('price', '>=', 300000000);
                        } elseif ($price == '>900') {
                            $q->orWhere('price', '>=', 900000000);
                        }
                    }
                });
            })
            ->when($request->input('search'), function ($query, $search) {
                $query->where('model', 'like', '%' . $search . '%')
                      ->orWhere('brand', 'like', '%' . $search . '%');
            });
    }
}