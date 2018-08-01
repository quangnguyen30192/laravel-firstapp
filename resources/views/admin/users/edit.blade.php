@extends('layouts.admin')

@section('content')
    <h1>Edit user</h1>
    <div class="col-sm-3">
            <img src="{{asset($user->photos()->count() > 0 ? $user->photos()->first()->path : "images/noimg.jpeg")}}"
                 class="img-responsive img-rounded">
    </div>
    <div class="col-sm-9">
        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id], 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name: ', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email: ', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('role_id', 'Role: ', ['class' => 'control-label']) !!}
            {!! Form::select('role_id', $roles, null, ['placeholder' => 'Choose an option', 'class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status: ', ['class' => 'control-label']) !!}
            {!! Form::select('is_active', [1 => 'Active', 0 => 'Not Active'], null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('file', 'Image: ', ['class' => 'control-label']) !!}
            {!! Form::file('file', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Update User', ['class' => 'btn btn-primary']) !!}
        </div>

        @include('includes.form_errors')
        {!! Form::close() !!}
    </div>
@endsection