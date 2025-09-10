<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user');

        return redirect()->back()->with('success', 'تم إضافة التعليق');
    }


    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            abort(403, 'غير مسموح لك بحذف هذا التعليق ');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'تم حذف التعليق 🗑️');
    }
}
