@extends('layouts.app')

@section('content')
    <h1>Welcome to post edit page</h1>

    <form action="{{route('posts.update', $post->id)}}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="title" id="Enter title" value="{{$post->title}}">
        <input type="submit" name="submit">
        {{ csrf_field() }}
    </form>

    <form action="{{route('posts.destroy', $post->id)}}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="delete">
    </form>

@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection