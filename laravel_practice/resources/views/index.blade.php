@extends('layouts.app')

@section('content')
    <div>
        <h1>index!!</h1>
        {{ print_r(URL(''))}}
        <img src="{{ URL('storage/bluedog.PNG')}}" alt="">
        <img src="{{ asset('storage/bluedog.PNG')}}" alt="">
    </div>
@endsection
