<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Constants\RoleConstant;  // Import class RoleConstant
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Menentukan role_id berdasarkan email menggunakan RoleConstant
        $roleId = $this->getRoleIdByEmail($request->email);

        // Membuat user baru dan menyertakan role_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,  // Menambahkan role_id yang ditentukan
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Menentukan role_id berdasarkan email
     */
    private function getRoleIdByEmail($email)
    {
        // Logika penentuan role berdasarkan adanya kata "dealer" dalam email
        if (strpos($email, 'dealer') !== false) {
            return RoleConstant::DEALER;  // Gunakan RoleConstant untuk DEALER jika ada kata "dealer"
        }
        return RoleConstant::CUSTOMER;  // Gunakan RoleConstant untuk CUSTOMER jika tidak ada kata "dealer"
    }
}
