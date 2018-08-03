@extends("layouts.admin")

@section("content")

    @if (session('deleted_user'))
        <div class="container">
            <p class="bg-danger">{{session('deleted_user')}}</p>
        </div>
    @endif

    @if($users !== null && count($users) > 0)
        <h1>Users</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
            </thead>
            <tbody>

                <ul>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><img height="100"
                                     src="{{asset($user->photos()->count() > 0 ? $user->photos()->first()->path : "images/noimg.jpeg")}}"></td>
                            <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->roles()->count() > 0 ? $user->roleNames() : "Not assigned yet"}}</td>
                            <td>{{$user->is_active == 1 ? "Active" : "Not Active"}}</td>
                            <td>{{$user->created_at->diffForHumans()}}</td>
                            <td>{{$user->updated_at->diffForHumans()}}</td>
                        </tr>
                    @endforeach
                </ul>
            </tbody>
        </table>

    @else

        <h1 class="text-center">No users available</h1>

    @endif
@endsection



