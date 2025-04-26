<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        // Ambil data customer yang sedang login
        $customer = Auth::guard('customer')->user(); // Menggunakan guard 'customer'
        return view('customer.profile', compact('customer')); // Pastikan file Blade ada di `resources/views/customer/profile.blade.php`
    }

    // Memperbarui data profil
    public function update(Request $request)
    {
        // Ambil data customer yang sedang login
        $customer = Auth::guard('customer')->user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // Maksimal ukuran foto 2MB
        ]);

        // Update foto jika diupload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($customer->photo) {
                Storage::delete('public/photos/' . $customer->photo);
            }

            // Simpan foto baru
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/photos', $filename);
            $customer->photo = $filename;
        }

        // Update data lainnya
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}