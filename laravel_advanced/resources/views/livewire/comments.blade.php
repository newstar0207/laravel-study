<div class="p-3">
    @auth
    <div>
        @if (session()->has('message'))
            <div>{{ session('message') }}</div>
        @endif
    </div>

    <section>
        @if ($image)
            <img src="{{$image->temporaryUrl()}}" class="w-100 h-100">
        @endif
        <input type="file" id="image" wire:model="image" wire:loading.attr="disabled">
        <div wire:loading wire:target="image" class="text-red-500 ml-3">
            File Uploading...
            @error('image')
            fail...
            @enderror
        </div>
    </section>

    <form wire:submit.prevent="addComment">
        <input wire:model.lazy="newComment" class="w-full shadow-inner p-4 border-b mb-4 rounded-lg focus:shadow-outline text-xl" placeholder="Add new Comment"></input>
        <button class="font-bold py-2 px-4 w-full bg-purple-400 text-lg text-white shadow-md rounded-lg ">Comment </button>
    </form>

    @error('newComment')
        <h1>newComment error {{ $message }}</h1>
    @enderror

    @foreach ($comments as $comment)
    {{-- <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> --}}

        <div class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4">
            <!-- card header -->
            <div class="flex flex-row justify-center mr-2">
                <div class="font-bold text-2xl">{{ $comment->writer->name }}</div>
                <p class="ml-8">{{ $comment->created_at->diffForHumans() }}</p>
            </div>

            <!-- card body -->
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- content goes here -->
                {{ $comment->content }}
            </div>

            @if ($comment->image)
                <img src="{{ $comment->Image_Path }}" alt="" width="200" class="border-b text-gray-500">
            @else
            @endif

            <div>
        </div>

            <!-- card footer -->
            <div class="bg-white border-gray-200 text-right">
                <i wire:click="$emit('deleteClicked', {{ $comment->id }})"  class="fas fa-times text-red-200 cursor-pointer hover:text-red-600 ml-2 mt-2" ></i>
                <i wire:click="$emit('openModal', 'edit-comment', {{ json_encode(["commentId" => $comment->id]) }})"  class="far fa-edit text-red-200 cursor-pointer hover:text-red-600 ml-2 mt-2" ></i>
            </div>


        </div>
    @endforeach

    {{ $comments->links() }}
    @endauth
</div>

<script>
    window.Livewire.on('deleteClicked', (commentId) => {
        if(confirm('Are you sure to delete?')) {
            window.Livewire.emit('delete', commentId);
        }
    });
</script>
