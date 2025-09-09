<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show a user's profile along with their posts
    public function show($id)
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('profile.show', compact('user'));
    }

    // Show the edit profile form
    public function edit($id)
    {
        // Check if the logged-in user is trying to edit their own profile
        if (Auth::id() != $id) {
            return redirect()->route('profile.show', $id)
                ->with('error', 'You are not authorized to edit this profile');
        }

        $user = User::findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    // Handle profile update
    public function update(Request $request, $id)
    {
        // Check if the logged-in user is trying to update their own profile
        if (Auth::id() != $id) {
            return redirect()->route('profile.show', $id)
                ->with('error', 'You are not authorized to update this profile');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio'           => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it's not the default
            if ($user->profile_image && $user->profile_image !== 'default.png') {
                Storage::disk('public')->delete('profiles/' . $user->profile_image);
            }

            $imagePath           = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = basename($imagePath);
        }

        // Update user details
        $user->update([
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'bio'           => $request->bio,
            'profile_image' => $user->profile_image,
        ]);

        return redirect()->route('profile.show', $user->id)
            ->with('success', 'Profile updated successfully');
    }

    // Delete the user's profile image
    public function destroyImage($id)
    {
        // Check if the logged-in user is authorized
        if (Auth::id() != $id) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }

        $user = User::findOrFail($id);

        if ($user->profile_image && $user->profile_image !== 'default.png') {
            Storage::disk('public')->delete('profiles/' . $user->profile_image);
            $user->profile_image = 'default.png';
            $user->save();
        }

        return response()->json(['success' => 'Profile image deleted successfully']);
    }
}
