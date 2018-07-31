@extends('layouts.admin')

@section('content')
<h1>Create User</h1>
{!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store']) !!}
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
        {!! Form::text('role_id', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status: ', ['class' => 'control-label']) !!}
        {!! Form::select('status', array(1 => 'Active', 0 => 'Not Active'),null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create User', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
@endsection