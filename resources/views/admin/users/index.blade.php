@extends("layouts.admin")

@section("content")
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
        @if(count($users))
            <ul>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        @if (count($user->photos))
                            <td><img height="100" src="{{asset($user->photos()->first()->path)}}"></td>
                        @else
                            <td>No Photo</td>
                        @endif
                        <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{empty($user->roles()) ? "N/A" : $user->roleNames()}}</td>
                        <td>{{$user->is_active == 1 ? "Active" : "Not Active"}}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            </ul>
        @endif

        </tbody>
    </table>
@endsection



