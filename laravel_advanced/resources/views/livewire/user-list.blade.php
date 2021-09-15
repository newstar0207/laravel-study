<div>
    @foreach ($users as $user)
    {{-- <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> --}}

        <div class="bg-white rounded-lg p-3  flex flex-row justify-center items-center md:items-start shadow-lg mb-4 {{ $userId == $user->id ? 'bg-green-100' : ''}}">
            <!-- card header -->
            <div class="flex flex-row justify-center mr-2 {{ $userId == $user->id ? 'bg-green-100' : ''}}">
                <div class="font-bold text-2xl">{{ $user->name }}</div>
            </div>

            <!-- card body -->
            <div class="p-6 bg-white border-b border-gray-200">
                {{ $user->current_team_id }}
            </div>


            <div class="bg-white border-gray-200 text-right">
                <i wire:click="$emit('userSelected', {{$user->id }})"  class="far fa-info-circle text-red-200 cursor-pointer hover:text-red-600 ml-2 mt-2" ></i>
            </div>

        </div>
    @endforeach
    {{-- {{ $users->link()}} --}}


</div>
