<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Pow;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function __construct()
    { // only <-> excepts
        $this->middleware(['auth'])->except(['index', 'show']); // 생성자를 만들어 auth 미들웨어를 무조건 거치게 함!
    }

    public function  show(Request $request, $id)
    {
        $page = $request->page;
        // dd($request);
        $post = Post::find($id);
        // dd($page);
        // $post->count++; // 메모리 상에서만 ++이라 save 해주어야 함 (조회수 증가)
        // $post->save(); // DB에 반영

        // 1. 이글을 조회한 사용자들 중에, 현재 로그인한 사용자가 포함되어 있는가 체크후 포함되어있지 않으면 추가, 포함되면 넘김.
        if (auth()->user() !== null && !$post->viewers->contains(auth()->user())) {
            $post->viewers()->attach(auth()->user()->id);
        }

        return view('posts.show', compact('page', 'post'));
    }

    public function create()
    {
        // dd('OK');/
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // $request->input['title']; // -> 변수에 접근할 경우
        // $request->input['content'];

        // 입력한 정보를 $request 로 받음

        $title = $request->title;
        $content = $request->content;

        $request->validate([
            'title' => 'required|min:3', // title은 꼭 필요하며 3자 이상
            'content' => 'required',
            'imageFile' => 'image|max:2000',
        ]); // 데이터를 검사

        // DB에 저장
        $post = new Post();
        $post->title = $title; // post 의 title
        $post->content = $content;
        $post->user_id = Auth::user()->id; // 지금 로그인한 사용자 user 모델 객채를 줌

        //File 처리
        //내가 원하는 파일시스템 상의 위치에 원하는 이름으로 파일을 저장
        if ($request->file('imageFile')) {
            $post->image = $this->uploadPostImage($request);
        }

        $post->save();

        // 결과 뷰를 반환
        //pulic 에 storage 를 하기 위해 소프트 링크를 걸어줌
        // php artisan storage:link
        return redirect('/posts/index');

        // dd($request);
    }

    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::latest()->paginate(5);
        // dd($posts);
        // $posts = Post::latest()->get();
        // dd($posts);

        return view('posts.index', compact('posts'));
        // dd($posts[0] -> created_at);
    }

    protected function UploadPostImage($request)
    {
        //File 처리
        // 내가 원하는 파일시스템 상의 위치에 원하는 이름으로 저장하며, 그 파일 이름을 컬럼에 설정;
        // $post -> image = $fileName;
        $name = $request->file('imageFile')->getClientOriginalName();
        $extension = $request->file('imageFile')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.' . $extension);
        $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;
        // dd($fileName);
        $request->file('imageFile')->storeAs('public/images', $fileName); // images 폴더 안에 $fileName으로 저장함
        // $post->image = $fileName; // DB에 저장
        // 그 파일 이름을 컬럼에 설정
        return $fileName;
    }

    public function edit(Request $request, Post $post)
    {
        // 수정 폼 생성
        // $post = Post::where('id', $id)-> get();
        // dd($post);
        return view('posts.edit', ['post' => $post, 'page' => $request->page]);
    }

    public function update(Request $request, $id)
    {
        // 이미지 파일 수정, 파일시스템에서
        // 게시글을 DB에서 수정
        $request->validate([
            'title' => 'required|min:3', // title은 꼭 필요하며 3자 이상
            'content' => 'required',
            'imageFile' => 'image|max:2000',
        ]); // 데이터를 검사

        $post = Post::find($id);

        // Authorization. 즉 수정 권한이 있는지 검사
        // 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if(auth()-> user()->id == $post->user_id){
        //     abort(403);
        // }

        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }


        // 이미지 파일 수정, 파일시스템에서
        if ($request->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = $this->UploadPostImage($request);
        }

        // 게시글을 데이터베이스에서 수정
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('posts.show', ['id' => $id, 'page' => $request->page]); // router parameter

    }

    public function destroy(Request $request, $id)
    {
        // 파일 시스템에서 이미지 파일 삭제
        // 게시글을 데이터베이스 에서 삭제


        $post = Post::findOrFail($id); // not find exception 발생 / find 인 경우 null 값

        // Authorization. 즉 수정 권한이 있는지 검사
        // 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if(auth()-> user()->id == $post->user_id){
        //     abort(403);
        // }

        if ($request->user()->cannot('delete', $post)) {
            abort(403);
        }

        $page = $request->page;
        if ($post->image) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
        }
        $post->delete();

        return redirect()->route('posts.index', ['page' => $page]);
    }

    public function myindex()
    {
        // dd('ok1!!!');
        // $user = auth()->user()->posts; // posts (Post.php 의 posts() 메소드)
        // dd($user);
        // dd(auth()->user()->posts());
        $posts = auth()->user()->posts()->latest()->paginate(5);
        // dd($myposts);
        // $posts =  auth()->user()->posts()->latest()->paginate(5);
        // dd(auth()->user()); // 현재 로그인한 사용자 정보

        // dd($posts);
        return view('posts.index', compact('posts'));
    }

    public function test()
    {
        $this->data = User::all();
        dd($this->data->assertDatabaseHas('users', ['name' => 'newstar0207@g.yju.ac.kr']));
    }
}
