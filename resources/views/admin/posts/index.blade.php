@extends("layouts.admin")

@section("content")
    <h1>Posts</h1>
    @if (session('deleted_post'))
        <div class="container">
            <p class="bg-danger">{{session('deleted_post')}}</p>
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Content</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
        </thead>
        <tbody>
        @if($posts)
            <ul>
                @foreach($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td><img height="100" width="100"
                                 src="{{asset($post->photos()->count() > 0 ? $post->photos()->first()->path : "images/noimg.jpeg")}}">
                        </td>
                        <td><a href="{{route('posts.edit', $post->id)}}">{{$post->title}}</a></td>
                        <td>{{$post->category->name ?? "Uncategorized"}}</td>
                        <td>{{$post->content ?? "Empty"}}</td>
                        <td>{{$post->created_at->diffForHumans()}}</td>
                        <td>{{$post->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            </ul>
        @endif

        </tbody>
    </table>
@endsection



