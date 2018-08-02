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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('/admin/user/roles', ['middleware' => 'role', function () {
    return "Middleware role";
}]);

Route::get('/admin/user/roles', ['middleware' => ['role', 'auth', 'web'], function () {
    return "Middleware role";
}]);

Route::get('/admin', 'AdminController@index');

Route::get('/demo-mail', function () {
    Mail::raw('test', function ($message) {
        $message->to('quangnbnse90114@gmail.com', 'Quang')->subject('Hello Quang how are you');
    });
});


Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('/admin/users', 'AdminUsersController');
    Route::resource('/admin/posts', 'AdminPostsController');
    Route::resource('/admin/categories', 'AdminCategoriesController');
    Route::resource('/admin/media', 'AdminMediaController');
});

