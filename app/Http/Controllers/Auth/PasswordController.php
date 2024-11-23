<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Assert;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        Assert::that($user !== null, 'User must be authenticated');
        /** @var \App\Models\User $user */

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
