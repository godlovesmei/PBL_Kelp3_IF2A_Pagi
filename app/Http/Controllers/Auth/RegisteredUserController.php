<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Dealer;
use App\Constants\RoleConstant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dari request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Menentukan role_id berdasarkan email
        $roleId = $this->getRoleIdByEmail($request->email);

        // Membuat user baru dengan role_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);

        // Menambahkan data ke tabel customers atau dealers berdasarkan role_id
        if ($roleId === RoleConstant::CUSTOMER) {
            Customer::create([
                'cust_id' => $user->user_id,
            ]);
        } elseif ($roleId === RoleConstant::DEALER) {
            Dealer::create([
                'dealer_id' => $user->user_id,
            ]);
        }

        // Memicu event Registered
        event(new Registered($user));

        // Login user baru
        Auth::login($user);

        // Redirect ke halaman home
        return redirect(route('pages.home'));
    }

    /**
     * Menentukan role_id berdasarkan email.
     */
    private function getRoleIdByEmail(string $email): int
    {
        // Logika penentuan role berdasarkan kata "dealer" dalam email
        if (strpos($email, 'dealer') !== false) {
            return RoleConstant::DEALER;
        }

        return RoleConstant::CUSTOMER;
    }
}