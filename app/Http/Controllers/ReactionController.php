<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function toggle(Request $request)
    {
        // مؤقتًا: اعتبر أول يوزر في الجدول هو اللي بيعمل الريأكشن
        $user = \App\Models\User::first();

        $postId = $request->post_id;
        $type = $request->type;

        // هل الريأكشن دا موجود قبل كدا؟
        $reaction = Reaction::where('post_id', $postId)
                            ->where('user_id', $user->id)
                            ->first();

        if ($reaction) {
            if ($reaction->type === $type) {
                // نفس الريأكشن → امسحه
                $reaction->delete();
                $status = 'removed';
            } else {
                // غير الريأكشن
                $reaction->type = $type;
                $reaction->save();
                $status = 'updated';
            }
        } else {
            // أول مرة يضيف ريأكشن
            Reaction::create([
                'post_id' => $postId,
                'user_id' => $user->id,
                'type'    => $type,
            ]);
            $status = 'added';
        }

        // رجّع عدد الريأكشنات الجديد
        $count = Reaction::where('post_id', $postId)->count();

        return response()->json([
            'status' => $status,
            'count'  => $count,
        ]);
    }
}