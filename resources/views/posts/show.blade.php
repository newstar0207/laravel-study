
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
            <style>
                .hide-scroll-bar {
                -ms-overflow-style: none;
                scrollbar-width: none;
                }
                .hide-scroll-bar::-webkit-scrollbar {
                display: none;
                }
            </style>
    </head>
    <body>
        <div class="p-56">
            <div class="w-96 m-auto ">
                <div class=" grid grid-cols-3 grid-rows-7 grid-flow-row overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out" >
                    <div class="col-span-3 row-span-4 p-1 m-1"> {{-- 전체 판 --}}
                        <div> <a href="{{ route('posts.index', ['page'=>$page]) }}">post list</a> </div>
                            <img
                            src="{{$post -> imagePath()}}"
                            alt="Placeholder"
                            class="rounded-t-xl object-cover h-48 w-full"
                            />
                    </div>

                    <div class="col-span-3 row-span-1">
                        <div class="flex align-bottom flex-col leading-none p-2 md:p-4">
                            <div class="flex flex-row justify-between items-center">
                                {{-- $post -> image ?? 'default image'; --}}
                                {{-- <img
                                    src="/storage/images/{{$post -> image}}"
                                    alt="Placeholder"
                                    c/lass="rounded-t-xl object-cover h-48 w-full"
                                /> --}}
                                <span class="ml-2 text-sm"> {{ $post -> user->name}} </span><br>
                            </div>
                            <div name="content" id="content" class="ml-2 text-sm"> {!! $post -> content !!} </div>
                            <span class="ml-2 text-sm"> {{ $post -> created_at }} {{ $post -> updated_at }}</span>
                        </div>
                    </div>
                    {{-- Authorization --}}
                    @auth
                    {{-- @if (auth()->user()->id == $post->user_id) --}}
                    @can('update', $post)
                    <div class="flex" >
                        {{-- <button style="margin-left: 30px" type="button" onclick="location.href='{{route('posts.edit', ['post'=> $post->id, 'page' => $page])}}'">수정</a> --}}
                            <a type="button" onclick="location.href='{{route('posts.edit', ['post'=> $post->id, 'page' => $page])}}'" class="flex-1 border-2 border-grey-500 rounded-lg font-bold text-blue-500 px-5 py-1 transition duration-300 ease-in-out hover:bg-grey-500 hover:text-white mr-6">
                                수정
                            </a>
                            {{-- location.href 는 get 방식 --}}
                            <form action="{{ route('posts.delete', ['id' => $post ->id, 'page' => $page]) }}" method="post" class="flex-1">
                                @csrf
                                @method('delete')
                                {{-- <button type='sumbit' style="margin-left: 30px" type="button">삭제</a> --}}
                                <button type="submit" class="flex-1 border-2 border-grey-500 rounded-lg font-bold text-blue-500 px-10 py-1 transition duration-300 ease-in-out hover:bg-grey-500 hover:text-white mr-6">
                                    삭제
                                </button>
                            </form>
                    </div>
                    <div class="col-span-3 row-span-4 p-1 m-1">
                        <form action="{{ route('comment.store', ['id'=>$post->id, 'page' => $page]) }}" method="post">
                            @csrf
                            <input type="text" name="comment" >
                            <button type="submit">댓글</button>
                        </form>
                    </div>
                    <div>
                        @foreach ($comments as $comment)
                        <div class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4">
                            <div class="flex flex-row justify-center mr-2">
                              <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">{{$comment->user_id}}</h3>
                            </div>
                              <p style="width: 90%" class="text-gray-600 text-lg text-center md:text-left ">{{ $comment->comment}} </p>
                          </div>
                        @endforeach
                    </div>
                </div>


                    @endcan
                    {{-- @endif    --}}
                    @endauth
        </div>
        </body>
</html>
