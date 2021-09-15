<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex w-12/12">

            <div class="bg-opacity-0 overflow-hidden w-2/12 mr-10">
                @livewire('user-list')
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-10/12">
                @livewire('comments')
            </div>
        </div>
    </div>
</x-app-layout>
