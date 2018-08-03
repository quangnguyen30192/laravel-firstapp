@extends("layouts.admin")

@section("content")
    <h1>Photos</h1>
    @if (session('deleted_photo'))
        <div class="container">
            <p class="bg-danger">{{session('deleted_photo')}}</p>
        </div>
    @endif
    @if($photos)
        <form action="{{route('admin.media.delete.multiple')}}" method="POST" class="form-inline">
            {{csrf_field()}}
            {{method_field('delete')}}

            <div class="form-group">
                <select name="checkBoxArray" class="form-control">
                    <option value="delete">Delete</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Delete">
            </div>


            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <ul>
                    @foreach($photos as $photo)
                        <tr>
                            <td><input type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                            <td>{{$photo->id}}</td>
                            <td>{{$photo->path}}</td>
                            <td><img height="100" width="100"
                                     src="{{asset($photo->path ?? "images/noimg.jpeg")}}">
                            </td>
                            <td>{{$photo->created_at->diffForHumans()}}</td>
                            <td>{{$photo->updated_at->diffForHumans()}}</td>
                            <td>
                                {!! Form::open(['method' => 'DELETE', 'action' => ['AdminMediaController@destroy', $photo->id]]) !!}
                                <div class="form-group">
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                </div>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                </ul>
                @endif

                </tbody>
            </table>
        </form>
@endsection