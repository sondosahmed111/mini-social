<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);

        if (auth()->id() !== $userToFollow->id) {
            Follow::firstOrCreate([
                'follower_id' => auth()->id(),
                'following_id' => $userToFollow->id
            ]);
        }

        return back()->with('success', 'تمت المتابعة ✅');
    }

    public function unfollow($id)
    {
        Follow::where('follower_id', auth()->id())
              ->where('following_id', $id)
              ->delete();

        return back()->with('success', 'تم إلغاء المتابعة ❌');
    }
}

