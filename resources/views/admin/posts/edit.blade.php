@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <img src="{{asset($post->photos()->count() > 0 ? $post->photos()->first()->path : "images/noimg.jpeg")}}"
                 class="img-responsive img-rounded">
        </div>
        <div class="col-sm-9">
            <h1>Create Post</h1>
            {!! Form::model($post, ['method' => 'PATCH', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) !!}
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
                {!! Form::submit('Update Post', ['class' => 'btn btn-primary col-sm-6']) !!}
            </div>

            @include('includes.form_errors')
            {!! Form::close() !!}

            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
            <div class="form-group">
                {!! Form::submit('Delete', ['class' => 'btn btn-danger col-sm-6']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection