<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        // $posts = DB::select('select * from posts');

        // $id = 1;
        // $posts = DB::table('posts')
        //     ->where('id', $id)
        //     ->get();

        // $posts = DB::table('posts')
        //     ->orderBy('id', 'desc')
        //     ->get();

        // $posts = DB::table('posts')
        //     ->inRandomOrder()
        //     ->get();

        // $posts = DB::table('posts')
        //     ->orderBy('id', 'desc')
        //     ->first();

        $posts = DB::table('posts')
            ->insert([
                'title' => 'new Title',
                'body' => 'new body',
            ]);


        dd($posts);
    }
}
