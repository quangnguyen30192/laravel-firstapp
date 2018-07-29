@extends('layouts.app')

@section('content')
    <h1>Welcome to post creation page</h1>

    {!! Form::open(['method' => 'POST', 'action' => 'PostController@store', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::file('file', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection