<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->user_name = auth()->user()->name;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();
        // dd($request->id);
        // $comments = Post::find($request->id)->comments; // redirect 에서 불림

        // dd($comment);
        // $request -> id // post_id;
        return redirect()->route('posts.show', ['id' => $request->id, 'page' => $request->page, 'comments' => $comment]);
        // dd($comment);
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        if ($request->edit == 'update') {
            // 업데이트 부분..
            $comment = Comment::find($id);
            $comment->comment = $request->comment;
            $comment->save();
        } else if ($request->edit == 'delete') {
            $comment = Comment::find($id);
            $comment->delete();
            // dd($request);
        }

        return redirect()->route('posts.show', [$request->post]);
    }
}
