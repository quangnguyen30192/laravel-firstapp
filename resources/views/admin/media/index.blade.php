@extends("layouts.admin")

@section("content")
    <h1>Photos</h1>
    @if (session('deleted_photo'))
        <div class="container">
            <p class="bg-danger">{{session('deleted_photo')}}</p>
        </div>
    @endif
    @if($photos)
        <form action="{{route('media.destroy')}}" method="POST" class="form-inline">
            {{csrf_field()}}
            {{method_field('delete')}}

            <div class="form-group">
                <select name="checkBoxArray" class="form-control">
                    <option value="delete">Delete</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" name="delete_multiple" value="Delete">
            </div>


            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkAllBoxes"></th>
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
                            <td><input type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}" class="childBoxes">
                            </td>
                            <td>{{$photo->id}}</td>
                            <td>{{$photo->path}}</td>
                            <td><img height="100" width="100"
                                     src="{{asset($photo->path ?? "images/noimg.jpeg")}}">
                            </td>
                            <td>{{$photo->created_at->diffForHumans()}}</td>
                            <td>{{$photo->updated_at->diffForHumans()}}</td>
                            <td>
                                <div class="form-group">
                                    <input type="hidden" name="media_single_id" value="{{$photo->id}}">
                                    <input type="submit" class="btn btn-danger" name="delete_single" value="Delete">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </ul>
                @endif

                </tbody>
            </table>
        </form>
@endsection

@section('script')
    <script>
        $('#checkAllBoxes').click(function () {
            let parentStatus = this.checked;
            $('.childBoxes').each(function () {
                this.checked = parentStatus;
            });

        });
    </script>
@endsection