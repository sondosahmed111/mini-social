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

        $comment = $post->comments()->create([
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user');

        return redirect()->back()->with('success', 'تم إضافة التعليق');
    }

    // تعديل تعليق
    public function update(Request $request, Comment $comment)
    {
        // تحقق إن المستخدم هو صاحب التعليق
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'غير مسموح لك بتعديل هذا التعليق');
        }

        // التحقق من البيانات
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        // تحديث التعليق
        $comment->update([
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'تم تعديل التعليق بنجاح');
    }

    // حذف تعليق
    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            abort(403, 'غير مسموح لك بحذف هذا التعليق');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'تم حذف التعليق 🗑️');
    }
    public function edit(Comment $comment)
{
    // رجع نفس الصفحة مع تحديد إن الكومنت ده بيتعدل
    return redirect()->back()->with('edit_comment_id', $comment->id);
}

}
