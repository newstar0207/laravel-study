<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <!-- component -->
    <div class="flex justify-center h-screen items-center bg-gray-200 antialiased">
        <div class="flex flex-col w-11/12 sm:w-5/6 lg:w-1/2 max-w-2xl mx-auto rounded-lg border border-gray-300 shadow-xl">
        <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">

        </div>
        <div class="flex flex-col px-6 py-5 bg-gray-50">
            <p class="mb-2 font-semibold text-gray-700">Comment</p>
            <textarea wire:model='newComment'
            type="text"
            name=""
            placeholder="Type message..."
            class="p-5 mb-5 bg-white border border-gray-200 rounded shadow-sm h-36"
            id=""
            ></textarea>
            <div class="flex flex-col sm:flex-row items-center mb-5 sm:space-x-5">

            </div>
            <hr />
            <div class="flex flex-row items-center justify-between p-5 bg-white border border-gray-200 rounded shadow-sm">

                {{-- @if ($image)
                    <img class="w-10 h-10 mr-3 rounded-full" src={{ $image->temporaryUrl() }}/>
                @elseif ($orgComment->image)
                   <img class="w-10 h-10 mr-3 rounded-full" src={{ $orgComment-> 'localhost:8000/'.Image_Path }}/>
                @endif --}}
                <img class="w-10 h-10 mr-3 rounded-full" src='http://localhost:8000/'. {{ $orgComment-> Image_Path }}/>
                <input type="file" wire:model = 'image' wire:loading.attr = 'disabled'>
                <div wire:loading wire:target='image'> Uploading...</div>
            </div>

            <div class="flex items-center mt-5 mb-3 space-x-4">

            <br />
            </div>

        <div
            class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg"
        >

            <button wire:click='$emit("update")' class="px-4 py-2 text-white font-semibold bg-blue-500 rounded">
            Update
            </button>
            <button wire:click="$emit('closeModal')" class="px-4 py-2 text-white font-semibold bg-blue-500 rounded">
            Cancel
            </button>
        </div>
        </div>
    </div>

</div>
