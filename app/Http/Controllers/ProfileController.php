<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     */
    public function edit(Request $request): View
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            // Delete previous avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's avatar.
     */
    public function destroyAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile photo removed successfully.');
    }
}
