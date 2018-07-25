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

use App\Students;

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