@extends('layouts.app')

@section('content')
    <h1>You are reading the post: {{$post->title}}</h1>
    <div class="image-container">
        <img src="{{asset($post->img_file)}}" alt="">
    </div>
@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection