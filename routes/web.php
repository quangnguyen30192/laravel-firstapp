<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Country;
use App\Photo;
use App\Post;
use App\Role;
use App\Students;
use App\Tag;
use App\User;
use App\Video;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', 'StudentsController');

Route::get('/contact', 'StudentsController@contact');

Route::get('/contact/{name}/{param1}/{param2}', 'StudentsController@contactStudent');

Route::get('/students', function () {

    $students = Students::all();

    return $students;
});

Route::get('/demo-create', function () {
    $students = new Students;
    $students->f_name = "quang";
    $students->l_name = "nguyen";

    $students->save();
});

Route::get('/demo-update', function () {
    Students::where('id', 1)->update(['f_name'=> 'quang-update']);
});

Route::get('/demo-delete', function () {
    $student = Students::find(1);
    $student->delete();
});

Route::get('/soft-delete', function () {
    $student = Students::find(3);
    $student->delete();
});

Route::get('/read-soft-delete', function () {
    $student = Students::withTrashed()->get();
    return $student;
});

Route::get('/show-only-trashed', function () {
    $student = Students::onlyTrashed()->get();
    return $student;
});

Route::get('/restore-trashed', function () {
    $student = Students::where('id', 3)->restore();
    return $student;
});

Route::get('/force-delete', function () {
    $student = Students::where('id', 3)->forceDelete();
    return $student;
});

Route::get('/users/{id}/post', function ($id) {
    return User::find($id)->post;
});

Route::get('/posts/{id}/user', function ($id) {
    return Post::find($id)->user;
});

Route::get('/users/{id}/posts', function ($id) {
    $posts = User::find($id)->posts;
    foreach ($posts as $post) {
        echo $post->title . "<br>";
    }
});

Route::get('/users/{id}/roles', function ($id) {
    $roles = User::find($id)->roles;
    return $roles;
});

Route::get('/roles/{id}/users', function ($id) {
    $users = Role::find($id)->users;
    return $users;
});

Route::get('/users/{id}/pivot', function ($id) {
    $roles = User::find($id)->roles;

    foreach ($roles as $role) {
        echo $role->pivot;
    }
});

Route::get('/country/{id}/post', function ($id) {
    $posts = Country::find($id)->posts;
    foreach ($posts as $post) {
        echo $post->title;
    }
});

Route::get('/user/{id}/photo', function ($id) {
    $photos = User::find($id)->photos;

    foreach ($photos as $photo) {
        echo $photo->path . "<br/>";
    }
});

Route::get('/post/{id}/photo', function ($id) {
    $photos = Post::find($id)->photos;

    foreach ($photos as $photo) {
        echo $photo->path . "<br/>";
    }
});

Route::get('/photo/{id}/type', function ($id) {
    $imageable = Photo::find($id);

    echo $imageable->imageable_type. "<br/>";
    echo $imageable;
});

Route::get('/post/{id}/tag', function ($id) {
    $tags = Post::find($id)->tags;
    foreach ($tags as $tag) {
        echo $tag->name . "<br/>";
    }
});

Route::get('/video/{id}/tag', function ($id) {
    $tags = Video::find($id)->tags;
    foreach ($tags as $tag) {
        echo $tag->name . "<br/>";
    }
});

Route::get('/tag/{id}/video', function ($id) {
    $tags = Tag::find($id);
    foreach ($tags->videos as $video) {
        echo $video->name . "<br/>";
    }
});