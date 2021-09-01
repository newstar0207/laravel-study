<div>
    @foreach ($comments as $comment)
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md">
            <!-- card header -->
            <div class="px-6 py-4 bg-white border-b border-gray-200 font-bold uppercase">
                What is Lorem Ipsum?
            </div>

            <!-- card body -->
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- content goes here -->
                {{ $comment->content }}
            </div>

            <!-- card footer -->
            <div class="p-6 bg-white border-gray-200 text-right">
                <!-- button link -->
                <a class="bg-blue-500 shadow-md text-sm text-white font-bold py-3 md:px-8 px-4 hover:bg-blue-400 rounded uppercase"
                href="#">Click Me</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
