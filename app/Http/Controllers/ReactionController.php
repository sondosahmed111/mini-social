<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $user = Auth::user();
        $type = $request->type;

        if (!$user) {
            return response()->json(['error' => 'يجب تسجيل الدخول أولاً'], 401);
        }

        // تحقق إذا المستخدم سبق وعمل ريأكشن على البوست
        $reaction = Reaction::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

        // متغير لتحديد الريأكشن الحالي للمستخدم
        $userReaction = $type;

        if ($reaction) {
            // لو نفس النوع ضغط عليه، شيل الريأكشن
            if ($reaction->type === $type) {
                $reaction->delete();
                $userReaction = null; // المستخدم شال الريأكشن
            } else {
                // لو نوع مختلف، حدثه
                $reaction->type = $type;
                $reaction->save();
            }
        } else {
            // إنشاء ريأكشن جديد
            Reaction::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
                'type' => $type,
            ]);
        }

        // رجع عدد الريأكشن لكل نوع للبوست
        $counts = [
            'like' => $post->reactions()->where('type','like')->count(),
            'love' => $post->reactions()->where('type','love')->count(),
            'haha' => $post->reactions()->where('type','haha')->count(),
            'wow' => $post->reactions()->where('type','wow')->count(),
            'sad' => $post->reactions()->where('type','sad')->count(),
            'angry' => $post->reactions()->where('type','angry')->count(),
        ];
dd($counts)
        // return response()->json([
        //     'status' => true,
        //     'counts' => $counts,
        //     'user_reaction' => $userReaction,
        // ]);
    }
}
