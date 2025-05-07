<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Car;

class WishlistController extends Controller
{
    // Tampilkan halaman wishlist
    public function index()
    {
        $user = Auth::guard('customer')->user();

        if ($user) {
            $wishlists = Wishlist::where('customer_id', $user->id)
                ->with('car')
                ->get();
            
            $showModal = false;
        } else {
            $wishlists = collect(); // Selalu Collection, bukan array kosong
            $showModal = true;
        }

        return view('pages.wishlist', compact('wishlists', 'showModal'));
    }

    // Tambahkan item ke wishlist
    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'You need to log in to add items to your wishlist.',
            ], 401);
        }

        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        $carId = $request->car_id;

        $exists = Wishlist::where('customer_id', $customer->id)
            ->where('car_id', $carId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This car is already in your wishlist.',
            ], 400);
        }

        Wishlist::create([
            'customer_id' => $customer->id,
            'car_id' => $carId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Car successfully added to your wishlist.',
        ]);
    }

    // Hapus item dari wishlist
    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('car_id', $id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Item successfully removed from wishlist.');
        }

        return redirect()->back()->with('error', 'The car you are trying to remove is not found in your wishlist.');
    }
}
