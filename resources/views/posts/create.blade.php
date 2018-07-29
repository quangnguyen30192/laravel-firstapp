@extends('layouts.app')

@section('content')
    <h1>Welcome to post creation page</h1>

    <form action="/posts" method="post">
        <input type="text" name="title" id="Enter title">
        <input type="submit" name="submit">
    </form>

@stop

@section('footer')
    <h3>I'm footer</h3>
@stop