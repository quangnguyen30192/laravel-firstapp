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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students/{id}/{name}', function ($id, $name) {
    return "Hello student with id: ". $id. " - name: ". $name;
});


Route::get('/teachers', array('as' => 'admin.home', function () {
    $url = route('admin.home');

    return "your url: " . $url;
}));
