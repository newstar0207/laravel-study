
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
                    <div class="col-span-3 row-span-4 p-1 m-1">
                        <div> <a href="{{ route('posts.index', ['page'=>$page]) }}">post list</a> </div>
                            {{-- <img  
                            src="https://picsum.photos/640/400/?random"
                            alt="Placeholder"
                            class="rounded-t-xl object-cover h-48 w-full"
                            /> --}}
                    </div>

                    <div class="col-span-3 row-span-1">
                        <div class="flex align-bottom flex-col leading-none p-2 md:p-4">
                            <div class="flex flex-row justify-between items-center">
                                {{-- <img
                                alt="Placeholder"
                                class="block rounded-full"
                                src="https://picsum.photos/32/32/?random"
                                /> --}}
                                <span class="ml-2 text-sm"> {{ $post -> user_id}} </span><br>
                            </div>
                            <span class="ml-2 text-sm"> {{ $post -> content }} </span>
                            <span class="ml-2 text-sm"> {{ $post -> created_at }} {{ $post -> updated_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
</html>
