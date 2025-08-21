<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
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

        $request->user()->save();

 return Redirect::route('profile.edit', ['locale' => app()->getLocale()])->with('status', 'profile-updated');

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
public function updatePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => ['required', 'image', 'max:2048'], // 2MB Max
    ]);

    /** @var \App\Models\User $user */
    $user = $request->user();

    // Find the profile or create it if it doesn't exist
    $profile = $user->profile()->firstOrCreate();

    // Delete the old photo if it exists
    if ($profile->profile_image_path) {
        Storage::disk('public')->delete($profile->profile_image_path);
    }

    // Store the new photo and get its path
    $path = $request->file('profile_photo')->store('profile_photos', 'public');

    // Save the new path to the user's profile
    $profile->update([
        'profile_image_path' => $path,
    ]);

    return back()->with('status', 'profile-photo-updated');
}
}
