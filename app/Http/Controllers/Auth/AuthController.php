<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // Untuk manajemen session
use App\Models\User;
use App\Models\Role;
use App\Constants\RoleConstant;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function processRegistration(Request $request)
    {
        // Validasi input data
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8', // Minimal 8 karakter
            ],
        ]);

        // Tentukan role berdasarkan logika email menggunakan RoleConstant
        $role = null;
        if (strpos(strtolower($request->email), 'dealer') !== false) { // Cek apakah ada kata 'dealer' di email
            $role = Role::where('role_id', RoleConstant::DEALER)->first();  // Gunakan RoleConstant::DEALER
        } else {
            $role = Role::where('role_id', RoleConstant::CUSTOMER)->first();  // Gunakan RoleConstant::CUSTOMER
        }

        // Pastikan role ditemukan
        if (!$role) {
            return redirect()->back()->with('error', 'Role tidak ditemukan.');
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->role_id, // Mengaitkan dengan role yang benar (menggunakan role_id)
        ]);

        // Simpan informasi pengguna ke session
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $role->role_name);

        // Redirect ke halaman login setelah registrasi berhasil
        session()->flash('success', 'Pendaftaran berhasil! Silakan login.');
        return redirect('/login');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login', ['role' => RoleConstant::CUSTOMER]); // Gunakan RoleConstant::CUSTOMER di sini
    }

    public function login(Request $request)
    {
        // Validasi data login
        $credentials = $request->only('email', 'password');
    
        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            // Login berhasil
            $user = Auth::user();
    
            // Simpan user_id ke session secara manual
            Session::put('user_id', $user->id);  // Menyimpan user_id di session
    
            // Simpan informasi pengguna ke session
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role->role_name);
    
            // Menyimpan pesan sukses login ke session
            session()->flash('success', 'Login berhasil!');
    
            // Redirect sesuai role pengguna
            if ($user->role->role_id === RoleConstant::CUSTOMER) {
                return redirect()->route('customer.home');
            } elseif ($user->role->role_id === RoleConstant::DEALER) {
                return redirect()->route('dealer.dashboard');
            }
    
            // Jika role tidak dikenali, arahkan ke halaman default
            return redirect()->route('home');
        } else {
            // Login gagal
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }
    }
    



    // Proses logout
    public function logout()
    {
        // Clear session
        Session::flush();  // Menghapus semua session data

        // Logout dari sistem
        Auth::logout();
        
        return redirect('/login');
    }
}
