@extends('layouts.app')

@section('content')
    <h1>Welcome to post edit page</h1>

{{--    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT']) !!}--}}
    {{--or--}}
    {!! Form::model($post, ['action' => ['PostController@update', $post->id], 'method' => 'PUT']) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    {!! Form::model($post, ['action' => ['PostController@destroy', $post->id],  'method' => 'DELETE']) !!}
    {!! Form::submit('Delete', ['class' => 'form-control']) !!}
    {!! Form::close() !!}

@endsection

@section('footer')
    <h3>I'm footer</h3>
@endsection