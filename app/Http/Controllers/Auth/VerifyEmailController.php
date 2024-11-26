<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Assert;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        Assert::that($user !== null, 'User must be authenticated');
        /** @var \App\Models\User $user */

        Assert::that($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail, 'User must implement MustVerifyEmail');
        /** @var MustVerifyEmail $user */

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
