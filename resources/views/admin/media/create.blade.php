@extends("layouts.admin")

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection

@section("content")
    <div class="row">
        <div class="col-sm-4">
            <h1>Upload media</h1>
            {!! Form::open(['method' => 'POST', 'action' => ['AdminMediaController@store'], 'class' => 'dropzone']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-sm-5">

        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@endsection