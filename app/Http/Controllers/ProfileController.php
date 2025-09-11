<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show authenticated user's profile with posts
    public function show()
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail(Auth::id());

        return view('profile.show', compact('user'));
    }

    // View other user's profile
    public function view($id)
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('profile.view', compact('user'));
    }
    public function followingList()
{
    $user = auth()->user();

    // جلب كل الناس اللي أنا متابعهم
    $followingUsers = $user->following()->get();

    return view('profile.following', compact('followingUsers'));
}

    // Show edit profile form (for logged-in user only)
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profile (for logged-in user only)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio'           => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && $user->profile_image !== 'default.png') {
                Storage::disk('public')->delete('profiles/' . $user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = basename($imagePath);
        }

        $user->update([
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'bio'           => $request->bio,
            'profile_image' => $user->profile_image,
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'تم تحديث البروفايل بنجاح');
    }

    // Delete profile image (reset to default)
    public function destroyImage()
    {
        $user = Auth::user();

        if ($user->profile_image && $user->profile_image !== 'default.png') {
            Storage::disk('public')->delete('profiles/' . $user->profile_image);
            $user->profile_image = 'default.png';
            $user->save();
        }

        return response()->json(['success' => 'تم حذف الصورة']);
    }

    // Follow a user
    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);

        if (auth()->id() == $userToFollow->id) {
            return back()->with('error', 'لا يمكنك متابعة نفسك');
        }

        if (!auth()->user()->following()->where('following_id', $userToFollow->id)->exists()) {
            auth()->user()->following()->attach($userToFollow->id);
        }

        return back()->with('success', 'تم متابعة المستخدم بنجاح');
    }

    // Unfollow a user
    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);

        auth()->user()->following()->detach($userToUnfollow->id);

        return back()->with('success', 'تم إلغاء متابعة المستخدم');
    }
}
