<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Reaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'reactions'])->latest()->get();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('posts', 'public') : null;

        Post::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'تم إنشاء المنشور بنجاح ✅');
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) Storage::disk('public')->delete($post->image);
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'تم تعديل المنشور بنجاح ✏️');
    }

    public function destroy(Post $post)
    {
        if ($post->image) Storage::disk('public')->delete($post->image);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'تم حذف المنشور 🗑️');
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    // ✅ Method وحيدة للتفاعل
    public function react(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        $user = auth()->user();

        // حذف أي ريأكشن قديم للمستخدم على نفس البوست
        Reaction::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->delete();

        // إضافة الريأكشن الجديد
        Reaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type'    => $request->type
        ]);

        // إعادة العدادات لكل نوع
        $counts = $post->reactions()->select('type')->get()
            ->groupBy('type')->map->count();

        return response()->json([
            'status' => true,
            'user_reaction' => $request->type,
            'counts' => $counts
        ]);
    }
}
