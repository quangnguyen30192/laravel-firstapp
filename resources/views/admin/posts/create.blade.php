@extends('layouts.admin')

@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'AdminPostsController@store', 'files' => true]) !!}
    <div class="form-group">
        {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('category_id', 'Category: ', ['class' => 'control-label']) !!}
        {!! Form::select('category_id', $categories, null, ['placeholder' => 'choose an option', 'class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('file', 'Image: ', ['class' => 'control-label']) !!}
        {!! Form::file('file', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content', 'Content: ', ['class' => 'control-label']) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create Post', ['class' => 'btn btn-primary']) !!}
    </div>

    @include('includes.form_errors')
    {!! Form::close() !!}
@endsection