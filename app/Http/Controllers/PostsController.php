<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Pow;

class PostsController extends Controller
{
    public function __construct()
    { // only <-> excepts
        $this->middleware(['auth']) -> except(['index', 'show']); // 생성자를 만들어 auth 미들웨어를 무조건 거치게 함!
    }
 
    public function  show( Request $request) {
        // dd($request);
        // $post = Post::find($id);   
        $page = $request -> page;
        return view('posts.show', compact('page'));
    }

    public function create() {
        // dd('OK');/
        return view('posts.create');
    }

    public function store(Request $request) {
        // $request->input['title']; // -> 변수에 접근할 경우
        // $request->input['content'];
        
        // 입력한 정보를 $request 로 받음

        $title = $request->title;
        $content = $request->content;

        $request -> validate([
            'title' => 'required|min:3', // title은 꼭 필요하며 3자 이상
            'content' => 'required'
        ]); // 데이터를 검사

        // DB에 저장
        $post = new Post();
        $post-> title = $title; // post 의 title
        $post-> content = $content;
        $post-> user_id = Auth::user() -> id; // 지금 로그인한 사용자 user 모델 객채를 줌
        $post -> save();

        return redirect('/posts/index');
        
        // dd($request);
    }
 
    public function index(Request $request ) {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::paginate(5);
        // $posts = Post::latest()->get();
        // dd($posts);   

        return view('/posts/index', ['posts' => $posts, 'page' => $request]); 
        // dd($posts[0] -> created_at);
    }
}

