@extends("layouts.admin")

@section("content")
    @if (session('deleted_category'))
        <div class="container">
            <p class="bg-danger">{{session('deleted_category')}}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-4">
            <h1>Create Category</h1>
            {!! Form::open(['method' => 'POST', 'action' => 'AdminCategoriesController@store']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name: ', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Create category', ['class' => 'btn btn-primary']) !!}
            </div>

            @include('includes.form_errors')
            {!! Form::close() !!}
        </div>
        <div class="col-sm-5">
            <table class="table ">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                </tr>
                </thead>
                <tbody>
                @if($categories)
                    <ul>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td><a href="{{route('categories.edit', $category->id)}}">{{$category->name}}</a></td>
                                <td>{{$category->created_at->diffForHumans()}}</td>
                                <td>{{$category->updated_at->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                    </ul>
                @endif

                </tbody>
            </table>
        </div>

    </div>

@endsection