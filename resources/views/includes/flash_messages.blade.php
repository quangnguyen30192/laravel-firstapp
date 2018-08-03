@if (Session::has('just_delete_thing'))
    <div class="alert alert-success col-sm-4">
        <p class="text-center">{{session('just_delete_thing')}}</p>
    </div>
@endif