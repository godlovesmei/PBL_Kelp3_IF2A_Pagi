<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Daftar mobil dengan filter dan sort
    public function index(Request $request)
    {
        $cars = $this->applyFilters($request)
            ->orderBy(...$this->sortColumn($request))
            ->paginate(12)
            ->withQueryString();

        $categories = Car::select('category')->distinct()->pluck('category')->sort();

        // Tambahkan logic wishlist: ambil id mobil yang sudah di-wishlist user
        $wishlistedCarIds = [];
if (auth()->check() && auth()->user()->customer) {
    $wishlistedCarIds = auth()->user()->customer->wishlistCars()->pluck('car_id')->toArray();
}

        return view('pages.shop', compact('cars', 'categories', 'wishlistedCarIds'));
    }

    // Detail mobil
    public function show($id)
    {
        $car = Car::with('colors')->findOrFail($id);
        $carPrice = $car->price;
        return view('pages.car-details', compact('car', 'carPrice'));
    }

    // Filtering mobil
    private function applyFilters(Request $request)
    {
        $query = Car::with('colors');

        // Category filter (array)
        if ($request->filled('category')) {
            $query->whereIn('category', (array) $request->input('category'));
        }

        // Price filter (array)
        if ($request->filled('price')) {
            $query->where(function ($q) use ($request) {
                foreach ((array) $request->input('price') as $price) {
                    if ($price == '<300') {
                        $q->orWhere('price', '<', 300_000_000);
                    } elseif ($price == '>300') {
                        $q->orWhere('price', '>=', 300_000_000);
                    } elseif ($price == '>900') {
                        $q->orWhere('price', '>=', 900_000_000);
                    }
                }
            });
        }

        // Search filter (model OR brand)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('model', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Tambahkan filter lain di sini (misal: tahun, warna, dsb)

        return $query;
    }

    // Sorting logic
    private function sortColumn(Request $request)
    {
        $sort = $request->input('sort');
        switch ($sort) {
            case 'price_asc':
                return ['price', 'asc'];
            case 'price_desc':
                return ['price', 'desc'];
            case 'newest':
            default:
                return ['created_at', 'desc'];
        }
    }
}
