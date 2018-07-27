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

use App\Post;
use App\Students;
use App\User;

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

Route::get('/user/{id}/post', function ($id) {
    return User::find($id)->post;
});

Route::get('/post/{id}/user', function ($id) {
    return Post::find($id)->user;
});