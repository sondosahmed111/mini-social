<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // إضافة تعليق جديد
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body'    => $request->body,
        ]);

        $post->user->notify(new \App\Notifications\PostCommented(auth()->user(), $post, $comment));

        return redirect()->back()->with('success', 'تم إضافة التعليق بنجاح');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'غير مسموح لك بتعديل هذا التعليق');
        }

        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment->update([
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'تم تعديل التعليق بنجاح');
    }

    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            abort(403, 'غير مسموح لك بحذف هذا التعليق');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'تم حذف التعليق 🗑');
    }
    public function edit(Comment $comment)
    {
        // رجع نفس الصفحة مع تحديد إن الكومنت ده بيتعدل
        return redirect()->back()->with('edit_comment_id', $comment->id);
    }
}
