@extends("layouts.admin")

@section("content")
    <div class="row">
        <div class="col-sm-4">
            <h1>Update Category</h1>
            {!! Form::model($category, ['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name: ', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update category', ['class' => 'btn btn-primary col-sm-6']) !!}
            </div>

            @include('includes.form_errors')
            {!! Form::close() !!}

            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}
            <div class="form-group">
                {!! Form::submit('Delete', ['class' => 'btn btn-danger col-sm-6']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-sm-5">

        </div>
    </div>

@endsection