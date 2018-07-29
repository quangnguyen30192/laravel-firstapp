@extends('layouts.app')

@section('content')
    <h1>Welcome to post creation page</h1>

    {!! Form::open(['method' => 'POST', 'action' => 'PostController@store']) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}

@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection