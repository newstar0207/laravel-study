<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Resources\Blog as BlogResource;
use Illuminate\Support\Facades\Validator;

class BlogController extends BaseController
{
    public function index()
    {
        $blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [ // make 메소드로 전달되는 첫번째 인자는 유효성 검사를 받을 데이터입니다
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist');
        }
        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }

    public function update(Request $request, Blog $blog)
    {
        // $blog = Blog::find($request->id); -> 이렇게도 쓸 수 있음!
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
