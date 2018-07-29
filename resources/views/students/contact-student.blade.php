@extends('layouts.app')

@section('content')
    <h1>Contact Student Page - extends from master layout </h1>
    <h2>Hello {{$name}} {{$param1}} {{$param2}}</h2>
@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection