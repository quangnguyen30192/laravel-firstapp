@extends('layouts.app')

@section('content')
    <h1>Welcome to post index page</h1>

    @if(count($posts))
        <ul>
            @foreach($posts as $post)
                <li><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></li>
            @endforeach
        </ul>
    @endif

    <a href="{{route('posts.create')}}">Go to post create page</a>


@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection