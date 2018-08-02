# Form - login

## Enable login module by scaffolding

```php
php artisan make:auth	
```



it would 

* create views/auth for login, password and register page
* override your `views/layout/app.blade.php`
* expand `Auth:routes()` (adding authentication routes) and `Auth::routes();Route::get('/home', 'HomeController@index')->name('home');` in to web.php
* return `/home` after login because of AuthController - $redirecTo = "/home";



### Get user logged in infor

```php
$user = Auth::user();
```



### check user logged in

```php
if(Auth:check()) {
    echo "logged in";
}
```



### Auth:attempt

```php
if (Auth::attempt(['email' => $email, 'password' => $password])) {
    // Authentication passed...
    return redirect()->intended('dashboard');
}
```



The `attempt` method accepts an array of key / value pairs as its first argument. The values in the array will be used to find the user in your database table. So, in the example above, the user will be retrieved by the value of the `email` column. If the user is found, the hashed password stored in the database will be compared with the hashed `password` value passed to the method via the array. If the two hashed passwords match an authenticated session will be started for the user.

The `attempt` method will return `true` if authentication was successful. Otherwise, `false`will be returned.

The `intended` method on the redirector will redirect the user to the URL they were attempting to access before being caught by the authentication filter. A fallback URI may be given to this method in case the intended destination is not available.



### Get logout

```
Auth:logout()
```



## Docs https://laravel.com/docs/5.5/authentication



# Middleware - Security/Protection

To handle an incoming request.

E.g a controller has middleware as auth

```php
public function __construct()
{
    $this->middleware('auth');
}
```

or

```php
public function __construct() {
    $this->middleware(['isAdmin', 'auth']);
}
```



'auth' an alias of Authenticate which  is from `http/Kernel` - $routeMiddleware

There are many middlewares in `http/middleware` folder

```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];
```



### Create a middleware

```php
php artisan make:middleware IsAdminMiddleware
```

### Assign into Kernel@$routeMiddleware

```
'isAdmin' => IsAdminMiddleware::class
```



Introduce Middleware logic

```php
public function handle($request, Closure $next)
{
    // Perform action before a request
	$user = Auth::user();
    if(!$user->isAdmin()) {
        return redirect('/');
    }

    return $next($request);
}
```



```php
public function handle($request, Closure $next)
{
    $response = $next($request);

	// Perform action after a request

	return $response;
}
```

###  Apply on a route

```php
Route::get('/admin/user/roles', ['middleware' => 'isAdmin', function () {

}]);

Route::get('/admin/user/roles', ['middleware' => ['auth', 'isAdmin'], function () {

}]);


Route::get('/', function () {
    //
})->middleware(['auth', 'isAdmin']);
```



or apply on a controller

```php
public function __construct() {
    $this->middleware(['isAdmin', 'auth']);
}

public function index() {
    return "hello admin:" . Auth::user()->name;
}
```



apply on a group of routes

```php
Route::group(['middleware' => 'web'], function () {
    Route::resource('/posts', 'PostController');
});

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('/admin/users', 'AdminUsersController');
    Route::resource('/admin/posts', 'AdminPostsController');
});

```



## Docs https://laravel.com/docs/5.5/middleware



# Laravel session

### create/update a session attritbute

```php
$request->$session->put(['name' => 'quang']);
session(['name' => 'quang']);
```



### read a session attribute

```php
$request->$session->get('name');
$request->$session->all();
session('name');
```



### delete a session attribute

```php
$request->session()->forget('name');
session()->forget('name');
```



### delete all session attritbutes

```php
$request->session()->flush();
session()->flush();
```



### Flash Data

Sometimes you may wish to store items in the session only for the next request. You may do so using the `flash` method. Data stored in the session using this method will only be available during the subsequent HTTP request, and then will be deleted. Flash data is primarily useful for short-lived status messages:

```
$request->session()->flash('status', 'Task was successful!');
```



### Docs: https://laravel.com/docs/5.2/session

