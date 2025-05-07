<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Check if the user's email is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        // Mark the user's email as verified
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user());
    }

    /**
     * Redirect the user based on their role.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        // Redirect based on role
        if ($user->hasRole('dealer')) {
            return redirect()->intended(route('pages.dealer.dashboard').'?verified=1');
        } elseif ($user->hasRole('customer')) {
            return redirect()->intended(route('pages.home').'?verified=1');
        }

        // Default redirect if no specific role is matched
        return redirect()->intended(route('pages.home').'?verified=1');
    }
}