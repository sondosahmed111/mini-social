<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostController extends Controller
{
    public function index()
    {
        $PostsfromDB = Post::all(); 
        return view('posts.index',['posts'=>$PostsfromDB]);
    }
    public function create()
    {
        $users = User::all();
        return view('posts.create', ['users'=> $users]);
    }
    public function store(Request $request)
    {
        // $request= request();
        // dd($request->title,$request->all());
        $data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $image = request()->image;
        // dd($title, $description, $image);
        // $Post = new Post;
        // $Post->title = $title;
        // $Post->description = $description;
        // $Post->image = $image;
        // $Post->save();
        Post::create([
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);

    return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    public function edit(Post $post)
    {

        $users = User::all();
        return view('posts.create', ['users'=> $users, 'post'=> $post]);
    }
    public function update($postId)
    {
        $singlePostfromDB = Post::findOrFail($postId);
        // $request= request();
        // dd($request->title,$request->all());
        $data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $image = request()->image;
        // dd($title, $description, $image);
        $singlePostfromDB->update([
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);
        return to_route('posts.show', ['post' => $postId]);
    }
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();


        return to_route('posts.index');

    }
    public function show(Post $post)
    {
        // $singlePostfromDB = Post::find($postId);//for id search

    //  $singlePostfromDB = Post::findOrFail($postId); // This returns a single model instance
    // //  if(is_null($singlePostfromDB)){
    //     return to_route('posts.index');
     return view('posts.show',['post'=>$post] );


    }

    

   
}