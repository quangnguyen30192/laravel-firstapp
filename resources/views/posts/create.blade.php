@extends('layouts.app')

@section('content')
    <h1>Welcome to post creation page</h1>

    <form action="{{route('posts.store')}}" method="POST">
        <input type="text" name="title" id="Enter title">
        <input type="submit" name="submit">
        {{ csrf_field() }}
    </form>

@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection