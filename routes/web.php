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


use App\User;
use Carbon\Carbon;

Route::group(['middleware' => 'web'], function () {
    Route::resource('/posts', 'PostController');
});


Route::get('/demo-dates', function () {
    $date = new DateTime();
    echo $date->format('m.d.Y');

    echo "<br/>";
    echo Carbon::now()->addDays(10)->diffForHumans();

    echo "<br/>";
    echo Carbon::now()->subMonth(5)->diffForHumans();

    echo "<br/>";
    echo Carbon::now()->yesterday()->diffForHumans();
});

Route::get('/demo-accessors', function () {
    echo User::find(1)->name;
});

Route::get('/demo-mutators', function () {
    $user = User::find(1);
    $user->name = "quang-nguyen";
    $user->save();
    $user = User::find(1);
    echo $user;
});