<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // عرض كل البوستات
    public function index()
    {
        $PostsfromDB = Post::with(['user', 'comments.user'])->latest()->get();

        return view('posts.index', ['posts' => $PostsfromDB]);
    }


    // صفحة إنشاء بوست جديد
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

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

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
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
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
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'تم حذف المنشور 🗑️');
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }
}
