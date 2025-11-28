<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
// Jangan lupa import Storage di paling atas file:
use Illuminate\Support\Facades\Storage; 

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */


public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    // LOGIKA UPLOAD FOTO PROFIL (BARU)
    if ($request->hasFile('avatar')) {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Hapus foto lama jika ada (agar tidak menuh-menuhin server)
        if ($request->user()->avatar) {
            Storage::disk('public')->delete($request->user()->avatar);
        }

        // Simpan foto baru
        $path = $request->file('avatar')->store('avatars', 'public');
        $request->user()->avatar = $path;
    }

    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
