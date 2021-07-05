<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Pow;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function __construct()
    { // only <-> excepts
        $this->middleware(['auth']) -> except(['index', 'show']); // 생성자를 만들어 auth 미들웨어를 무조건 거치게 함!
    }
 
    public function  show(Request $request, $id) {
        $page = $request -> page;
        // dd($request); 
        $post = Post::find($id);
        // dd($page);         
        return view('posts.show', compact('page', 'post'));
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
            'content' => 'required',
            'imageFile' => 'image|max:2000',
        ]); // 데이터를 검사

        // DB에 저장
        $post = new Post();
        $post-> title = $title; // post 의 title
        $post-> content = $content;
        $post-> user_id = Auth::user() -> id; // 지금 로그인한 사용자 user 모델 객채를 줌

        if( $request->file('imageFile')){
            //File 처리
            // 내가 원하는 파일시스템 상의 위치에 원하는 이름으로 저장하며, 그 파일 이름을 컬럼에 설정;
            // $post -> image = $fileName;
            $name = $request->file('imageFile')->getClientOriginalName();
            $extension = $request->file('imageFile')->extension();
            $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
            $fileName = $nameWithoutExtension.'_'.time().'.'.$extension;
            // dd($fileName);
            $request->file('imageFile')->storeAs('public/images', $fileName); // images 폴더 안에 $fileName으로 저장함
            $post->image = $fileName; // DB에 저장
        }
        $post -> save();
        //pulic 에 storage 를 하기 위해 소프트 링크를 걸어줌
        // php artisan storage:link
        return redirect('/posts/index');
        
        // dd($request);
    }
 
    public function index( ) {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::paginate(5);
        // dd($posts);            
        // $posts = Post::latest()->get();
        // dd($posts);       

        return view('/posts/index', compact('posts')); 
        // dd($posts[0] -> created_at);
    }
}

