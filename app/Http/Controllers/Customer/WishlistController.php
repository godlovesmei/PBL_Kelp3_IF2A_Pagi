<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Car;

class WishlistController extends Controller
{
    // Halaman wishlist
    public function index()
    {
        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->user();
            $wishlists = Wishlist::where('customer_id', $user->id)->with('car')->get();

            return view('customer.wishlist', [
                'wishlists' => $wishlists, // Gunakan nama variabel plural untuk konsistensi
                'showModal' => false, // Tidak perlu munculkan modal
            ]);
        }

        // Belum login
        return view('customer.wishlist', [
            'wishlists' => [], // Variabel kosong saat belum login
            'showModal' => true, // Munculkan modal login dari Blade
        ]);
    }

    // Tambah item ke wishlist
    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'You need to log in to add items to your wishlist.',
            ], 401); // Jika belum login, return 401
        }

        // Validasi input
        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        $carId = $request->car_id;

        // Cek apakah mobil sudah ada di wishlist
        $exists = Wishlist::where('customer_id', $customer->id)
            ->where('car_id', $carId)
            ->exists();

        if (!$exists) {
            // Jika belum ada, tambahkan ke wishlist
            Wishlist::create([
                'customer_id' => $customer->id,
                'car_id' => $carId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Car successfully added to your wishlist.',
            ]);
        }

        // Jika mobil sudah ada di wishlist
        return response()->json([
            'success' => false,
            'message' => 'This car is already in your wishlist.',
        ], 400);
    }

    // Hapus item dari wishlist
    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login'); // Arahkan ke login jika belum login
        }

        // Cari wishlist berdasarkan customer_id dan car_id
        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('car_id', $id)
            ->first();

        if ($wishlist) {
            $wishlist->delete(); // Hapus item wishlist
            return redirect()->back()->with('success', 'Item removed from wishlist.');
        }

        return redirect()->back()->with('error', 'The car you are trying to remove is not in your wishlist.');
    }
}