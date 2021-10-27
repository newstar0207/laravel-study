<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChatController extends Controller
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
    public function index($post_id)
    {
        // $chat = Post::find($post_id)->chats();

        // return Inertia::render('Post/Show', [
        //     'chats' => $chat
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {

        $request->validate([
            'chat' => 'required',
        ]);

        $chat = new Chat;
        $chat->chat = $request->chat;
        $chat->user_id = Auth::user()->id;
        $chat->post_id = $post_id;
        $chat->save();

        return Redirect::route('post.show', $post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, Chat $chat)
    {
        if (Auth::user()->id != $chat->user_id) {
            return Redirect::route('post.show', $chat->post_id);
        }

        $request->validate([
            'chat' => 'required'
        ]);
        $chat->chat = $request->chat;
        $chat->save();

        return Redirect::route('post.show', $chat->post_id);
    }

    public function destroy(Chat $chat)
    {
        if (Auth::user()->id != $chat->user_id) {
            return Redirect::route('post.show', $chat->post_id);
        }

        $chat->delete();
        return Redirect::route('post.show', $chat->post_id);
    }
}
