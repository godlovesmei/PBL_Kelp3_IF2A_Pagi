<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $dealer = $user->dealer; // relasi ke Dealer

        return view('pages.profile.edit', [
            'user' => $user,
            'dealer' => $dealer,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // --- Tambahan update dealer ---
        $dealer = $user->dealer;
        if ($dealer) {
            $dealer->sosmed_link = $request->input('sosmed_link');

            // Handle logo upload jika ada file baru
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($dealer->logo && Storage::disk('public')->exists($dealer->logo)) {
                    Storage::disk('public')->delete($dealer->logo);
                }
                $dealer->logo = $request->file('logo')->store('dealer-logos', 'public');
            }
            $dealer->save();
        }

        return Redirect::route('pages.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
