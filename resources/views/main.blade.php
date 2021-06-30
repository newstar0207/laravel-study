@extends('layout')

@section('title')
    main
@endsection

@section('content')
    main
    <ul>
    <?php foreach($books as $book): ?>
        <li><?php echo $book; ?></li>
    <?php endforeach; ?>  
        
    
    </ul>
@endsection