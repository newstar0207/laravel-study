<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>  
            #create {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            body {background:white !important;}
        </style>
    </head> 
    <body>
        <div class="heading text-center font-bold text-2xl m-5 text-gray-800">New Post</div>
        <div>
            <form class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl" action="{{ route('posts.update', ['id' => $post->id ])}} " method="POST" enctype="multipart/form-data">
                @csrf
                @method("put")
                {{-- method  spoofing --}}
                <input name="title" class="title bg-gray-100 border border-gray-300 p-2 mb-4 outline-none" spellcheck="false" placeholder="Title" type="text" value="{{ old('title') ? old('title') : $post->title }}">
                @error('title')
                    <div>{{ $message }}</div>
                @enderror
                <textarea name="content" id="content" type="text" value="{{ old('content') ? old('content') : $post->content }}" placeholder="Describe everything about this post here" class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none" ></textarea>
                @error('content')
                     <div>{{ $message }}</div>
                @enderror

                <!-- icons -->
                <div class="icons flex text-gray-500 m-2">
                    <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <input type="file" id="file" name="imageFile" src="{{$post -> imagePath() }}"/> {{--원래 이미지 불러옴 --}}
                </div>            
                
                @error('imageFile')
                    <div>{{ $message }}</div>
                @enderror

                <!-- buttons -->
                <div class="buttons flex">
                    <button class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto"><a href="{{route('posts.index')}}">Cancle</a></button>
                    <button type="submit" class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500">Post</div>
                </div>

            </form>
        </div>    
    </body>
</html>