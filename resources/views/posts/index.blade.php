<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head> 
    <body>
        <div id="menu" class="container mx-auto px-4 lg:pt-24 lg:pb-64">
            <div class="flex flex-wrap text-center justify-center">
                <a href="/posts/create">create post</a>
                <div class="w-full lg:w-6/12 px-4">
                    <h2 class="text-4xl font-semibold text-black">Our Posts</h2>
                    <p class="text-lg leading-relaxed mt-4 mb-4 text-gray-500">
                        게시글 리스트
                    </p>
                </div>
            </div>
            @foreach ($posts as $post)  
            <div class="flex flex-wrap mt-12 justify-center">
                <div class="grid grid-cols-1 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 gap-4">
                    <div class="col-span-2 sm:col-span-1 xl:col-span-1">
                        <img
                        alt="..."
                        src="https://source.unsplash.com/gUBJ9vSlky0"
                        class="h-24 w-24 rounded  mx-auto"
                        /> 
                    </div>
                    <div class="col-span-2 sm:col-span-4 xl:col-span-4">
                        <h3 class="font-semibold text-black">{{$post -> title }}</h3>
                        <p>
                            {{ $post-> content}} <br><br>
                            {{ $post-> created_at}}
                        </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1 xl:col-span-1 italic ">{{ $post -> user_id }}</div>        
                </div>
            </div>
            @endforeach
            <div >
                {{ $posts ->links() }}
            </div>
        </div>

    </body>
</html>