@extends('layouts.app')

@section('content')
    <h1>Contact Page - extends from master layout </h1>

    @if(count($people))
        <ul>
            @foreach($people as $person)
                <li>{{$person}}</li>
            @endforeach
        </ul>
    @endif

@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection