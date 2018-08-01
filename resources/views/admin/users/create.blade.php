@extends('layouts.admin')

@section('content')
<h1>Create User</h1>
{!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store', 'files' => true]) !!}
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
        {!! Form::select('role_id', ['' => 'Choose an option'] + $roles, null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status: ', ['class' => 'control-label']) !!}
        {!! Form::select('status', array(1 => 'Active', 0 => 'Not Active'), 0, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password: ', ['class' => 'control-label']) !!}
        {!! Form::password('password', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('file', 'Image: ', ['class' => 'control-label']) !!}
        {!! Form::file('file', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create User', ['class' => 'btn btn-primary']) !!}
    </div>

    @include('includes.form_errors')
{!! Form::close() !!}
@endsection