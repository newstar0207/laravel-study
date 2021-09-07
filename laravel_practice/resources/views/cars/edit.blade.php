@extends('layouts.app')

@section('content')
    <div class="m-auto w-1/2 py-24">
        <div class="text-center">
            <h1 class="text-5xl uppercase bold">Create car</h1>
        </div>
    </div>

    <div class="flex justify-center pt-20">
        <form action="/cars/{{ $car->id }}" method="post">
            @csrf
            @method('put')
            <div class="block">
                <input type="text"
                    class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-grey-400"
                    name="name"
                    placeholder="Brand name..."
                    value="{{ $car->name }}">

                <input type="text"
                    class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-grey-400"
                    name="founded"
                    placeholder="Founded..."
                    value="{{ $car->founded }}">

                <input type="text"
                    class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-grey-400"
                    name="description"
                    placeholder="Description..."
                    value="{{ $car->description }}">

                <button type="submit" class="bg-green-500 block shadow-5xl mb-10 p-2 w-80 uppercase font-bold">
                    Submit
                </button>

            </div>
        </form>
    </div>

@endsection
