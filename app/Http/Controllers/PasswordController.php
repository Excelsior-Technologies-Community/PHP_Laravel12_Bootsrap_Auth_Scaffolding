<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the change password page.
     */
    public function edit(): View
    {
        return view('password');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('password.edit')
            ->with('success', 'Password changed successfully.');
    }
}