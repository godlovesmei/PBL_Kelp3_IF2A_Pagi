<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Car;
use App\Constants\RoleConstant;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Jika user login, ambil wishlist-nya. Jika tidak, kembalikan koleksi kosong.
        $wishlists = $user 
            ? Wishlist::where('cust_id', $user->user_id)->with('car')->get()
            : collect();

        $showModal = !$user; // Tampilkan modal jika user belum login.

        return view('pages.wishlist', compact('wishlists', 'showModal'));
    }

    /**
     * Add an item to the wishlist.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'You need to log in to add items to your wishlist.'
            ], 401);
        }

        if ($user->role_id !== RoleConstant::CUSTOMER) {
            return response()->json([
                'success' => false, 
                'message' => 'Only customers can add items to the wishlist.'
            ], 403);
        }

        // Validasi request untuk memastikan bahwa car_id valid (harus ada di tabel cars.id).
        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        // Cek apakah mobil sudah ada di wishlist pengguna.
        if (Wishlist::where('cust_id', $user->user_id)->where('car_id', $request->car_id)->exists()) {
            return response()->json([
                'success' => false, 
                'message' => 'This car is already in your wishlist.'
            ], 400);
        }

        // Tambahkan mobil ke wishlist pengguna.
        Wishlist::create([
            'cust_id' => $user->user_id,
            'car_id' => $request->car_id,
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Car successfully added to your wishlist.'
        ]);
    }

    /**
     * Remove an item from the wishlist.
     */
    public function destroy($id)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'success' => false, 
            'message' => 'You need to log in to manage your wishlist.'
        ], 401);
    }

    if ($user->role_id !== RoleConstant::CUSTOMER) {
        return response()->json([
            'success' => false, 
            'message' => 'Only customers can remove items from the wishlist.'
        ], 403);
    }

    // Find the wishlist item by customer ID and car ID
    $wishlist = Wishlist::where('cust_id', $user->user_id)->where('car_id', $id)->first();

    if (!$wishlist) {
        return response()->json([
            'success' => false, 
            'message' => 'The car is not found in your wishlist.'
        ], 404);
    }

    // Delete the item from the wishlist
    $wishlist->delete();

    return response()->json([
        'success' => true, 
        'message' => 'Car successfully removed from your wishlist.'
    ]);
}
}
