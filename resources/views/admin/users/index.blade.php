@extends("layouts.admin")

@section("content")

    @include('includes.flash_messages')

    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>results->count()</th>
                <th>results->currentPage()</th>
                <th>results->firstItem()</th>
                <th>results->hasMorePages()</th>
                <th>results->lastItem()</th>
                <th>results->lastPage() (Not available when using simplePaginate)</th>
                <th>results->nextPageUrl()</th>
                <th>results->perPage()</th>
                <th>results->previousPageUrl()</th>
                <th>results->total() (Not available when using simplePaginate)</th>
                <th>results->url(page)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row">{{$users->count()}}</td>
                <td scope="row">{{$users->currentPage()}}</td>
                <td scope="row">{{$users->firstItem()}}</td>
                <td scope="row">{{$users->hasMorePages()}}</td>
                <td scope="row">{{$users->lastItem()}}</td>
                <td scope="row">{{$users->lastPage()}}</td>
                <td scope="row">{{$users->nextPageUrl()}}</td>
                <td scope="row">{{$users->perPage()}}</td>
                <td scope="row">{{$users->previousPageUrl()}}</td>
                <td scope="row">{{$users->total()}}</td>
                <td scope="row">{{$users->url(1)}}</td>
            </tr>
            </tbody>
        </table>
    </div>

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
                            <td><a href="{{route('users.edit', $user->slug)}}">{{$user->name}}</a></td>
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
        <div class="row">
            <div class="col-sm-6 col-sm-offset-5">
                {{ $users->links() }}
            </div>
        </div>
    @else

        <h1 class="text-center">No users available</h1>

    @endif
@endsection



