<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function create() {
        // dd('OK');/
        return view('posts.create');
    }

    public function store(Request $request) {
        // $request->input['title']; // -> 변수에 접근할 경우
        // $request->input['content'];

        $title = $request->title;
        $content = $request->content;
        
        dd($request);
    }
}

