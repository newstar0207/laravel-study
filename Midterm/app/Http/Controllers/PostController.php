<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = DB::table('posts')->latest()->get();
        // $post = $post->orderBy('created_at', 'desc')->get();


        return Inertia::render('Container', ['user' => Auth::user(), 'posts' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;

        // dd(Auth::user()->id);

        if ($request->image) {
            $newImageName = time() . $request->file('image')->getClientOriginalName();
            // $path = $request->file('image')->storeAs('images', $newImageName);
            // $post->image_path = $newImageName;
            $request->image->move(public_path('/storage/images'), $newImageName);
            // Storage::disk('local')->put('images/' . $newImageName, $request->image);
            $url = asset('storage/images/' . $newImageName);
            $post->image_path = $url;
        }
        // dd($url);
        $post->save();

        // return Inertia::render('Container', [
        //     'user' => Auth::user()
        // ]);
        return Redirect::route('post.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // dd($request);
        //
        // dd($request->image);

        if (Auth::user()->id != $post->user_id) {
            return Redirect::route('post.index');
        }

        if ($post->image_path != $request->image) {
            // dd($request);
            $updateImage = substr($post->image_path, 37);
            Storage::delete('public/images/' . $updateImage);
            $newImageName = time() . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('/storage/images'), $newImageName);
            $url = asset('storage/images/' . $newImageName);
            $post->image_path = $url;
        }

        // dd($post);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();



        return Redirect::route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id != $post->user_id) {
            return Redirect::route('post.index');
        }

        // Storage::delete('/storage/images/' . $post->image_path);
        $deleteImage = substr($post->image_path, 37);
        // dd($deleteImage);
        // Storage::disk('public')->delete('storage/images/' . $deleteImage);
        Storage::delete('public/images/' . $deleteImage);
        $post->delete();

        return Redirect::route('post.index');
    }

    public function show(Post $post)
    {
        // dd($post);
        // $chat = Post::find($post->id)->chats;
        $chat = Post::find($post->id)->chats()->orderBy('created_at', 'desc')->get();

        // dd($chat);
        return Inertia::render('Post/Show', ['user' => Auth::user(), 'post' => $post, 'chats' => $chat]);
    }
}
