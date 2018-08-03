# Email



## Email API: mailgun

* Signup mailgun



* Installing mail driver

  ```
  composer require guzzlehttp/guzzle
  ```

  

* Update your `.env`

  ```
  MAIL_DRIVER=mailgun
  MAILGUN_DOMAIN=sandboxf3c2afc7a2da4053ae192b6cd0bd4ca3.mailgun.org
  MAILGUN_SECRET=private-mailgun-key
  MAIL_FROM_ADDRESS=quang@nguyen.com
  MAIL_FROM_NAME=quangnguyen
  ```



* Sending very simple email

  ```php
  Mail::raw('test', function ($message) {
      $message->to('quangnbnse90114@gmail.com', 'Quang')->subject('Hello Quang how are you');
  });
  ```

  if there is error about guzzle package: check Client.php(guzzle/src) - configureDefaults - verify -> false

* Docs: https://laravel.com/docs/5.2/mail





# Error page

* 404 error: create `404.blade.php` in to `views/errors`



# Application

## Populate data from database to dropdown list

Controller

```php
$roles = Role::pluck('name', 'id')->all();
return view('admin.users.create', compact('roles'));
```



View

```php
{!! Form::select('role_id', ['' => 'Choose an option'] + $roles, null, ['class' => 'form-control']) !!}
```



## Redirect to route and forward to view

* Route: 

  When we define in `web.php`

  ```php
  Route::resource('/user', 'UserController');
  ```

  Then we would have below name of routes mapping to controller methods and URLs:

  ```
   POST      | users             | users.store      | UsersController@store    
   GET|HEAD  | users             | users.index      | UsersController@index    
   GET|HEAD  | users/create      | users.create     | UsersController@create   
   DELETE    | users/{user}      | users.destroy    | UsersController@destroy  
   PUT|PATCH | users/{user}      | users.update     | UsersController@update   
   GET|HEAD  | users/{user}      | users.show       | UsersController@show     
   GET|HEAD  | users/{user}/edit | users.edit       | UsersController@edit
  ```

  we use *route(routeName)* to get the value of corresponding url

   e.g: 

  * route('users.index') is app.dev/users
  * route('users.create') is app.dev/users/create
  * route('user.edit', 1) is app.dev/users/1/edit 

* View: refer to blade files in `views/`

* In Controller: we use 
  * `return view('users.index')` : forward to blade file

  *  `return redirect(route('users.index'))`: redirect to Controller method

  *  we dont use these below in Controller

     *  `return route('users.index')` : route('users.index') will return a string of url path - like 'app.dev/users' - then this command would return a blank page with this string

        ```php
        // it doesnt work, dont use it
        return route('users.index');
        
        // we use
        return redirect(route('users.index'));
        ```

        

     *  `return redirect(view('users.index'))`: this would go to blade file : `views/users/index.blade.php` directly without passing through index() method in controller then there will be some errors like missing parameters or missing business logic processing.

```php
// admin index page
public function index()
{
    $users = User::all();
    return view('admin.index', compact('users'));
}

...

// these below would go to index() in Controller
return redirect('/admin'); 
return redirect(route('admin.index'));

// go to edit() in Controller with a parameter - id
return redirect(route('admin.edit', $user->id));


    

// this below would go to views/admin/index.blade.php - not index() in Controller
return view('admin.index');

// from Controller we forward to admin/edit.blade.php within a parameter - user
return view('admin.edit', compact('user'));

```



* In blade files we use `route`  to map Controller method - not `view`

  ```php
  <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
  ```




## Redirect back

```
return redirect()->back(); // back to the page that sent the request
```



## Create a link

```php
<a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a>
```



## Custom error messages

Request

```php
public function messages() {
    return [
        'role_id.required' => 'Role is required',
        'is_active.required' => 'Status is required'
    ];
}
```



## Include a blade file

blade file

```php
@include('admin.form_error')
```



## Display an image

use asset with img_file is in public/

```
<img src="{{asset($post->img_file)}}" />
```



## String collection convert into string with implode

```php
$roleName = collect($this->roles)->map(function ($role) {
    return $role->name;
})->implode(' | ');
```



```php
// Create a new collection instance.
$collection = new Collection([
    ['name' => 'Laravel', 'version' => '5.1'],
    ['name' => 'Lumen', 'version' => '5.0']
]);

// Laravel, Lumen
$imploded = $collection->implode('name', ', ');
```

```php
// The make() method returns a collection instance.
$users = factory('App\User', 3)->make();

$notification = $users->take(2)->implode('name', ', ') .
                ' and '.$users->last()->name . 
                ' have recently followed you.';
```



## Form accessors

Laravel's [Eloquent Accessor](http://laravel.com/docs/5.2/eloquent-mutators#accessors-and-mutators) allow you to manipulate a model attribute before returning it. This can be extremely useful for defining global date formats, for example. However, the date format used for display might not match the date format used for form elements. You can solve this by creating two separate accessors: a standard accessor, *and/or* a form accessor.

```php
use FormAccessible;

/**
 * Get the attribute: date_of_birth for forms.
 *
 * @param  string  $value
 * @return string
 */
public function formDateOfBirthAttribute($value)
{
    return Carbon::parse($value)->format('Y-m-d');
}
```

 The accessor will automatically be called by the HTML Form Builder when attempting to pre-fill a form field when `Form::model()` is used.



## Implement Edit page

Form element should not have default value. If it does -> when a field is null, the value of field would get the default value and we dont know that problem.



## Table foreign keys should be unsigned - index

```php
$table->interger('category_id')->unsigned()->index();
$table->interger('store_id')->unsigned()->index();
```



## when delete a record

```
all the related records/files/data in other tables/directories should be deleted as well.
```



For automatically deleting in database: => set foreign key constraint on related model with cascade on delete.

E.g: when you delete a user and the records in Post table which has that user_id should be deleted as well.

Post table: migration file

```php
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

if user->id is as increment (integer, unsigned) 
 then user_id on post table $table->integer('user_id')->unsigned();
```



### Delete files in repository: public

```php
unlink(public_path() . "/" .$user->photos()->first()->path);
```



## include value in form by hidden input

```html
<input type="hidden" name="is_active" value="1" />
action: Controller@update
method PATCH
```



By this way we could re-use existing methods in controller (update ) rather than creating new one for different purposes

```php
submitting to action: Controller@enableThisOne, method POST

...
// somewhere in the controller
enableThisOne() {
    // update the post with is_active = 1
}
```



## Database query with eloquent where

```
App\User::whereSlug('quang-nguyen-ba')->first(); // to get the result

// not this
App\User::whereSlug('quang-nguyen-ba');


```



## fix csrf error on console log

Add the code below into your meta tags

```
<meta name="csrf-token" content="{{ csrf_token() }}">
```

Then, once you have created the `meta` tag, you can instruct a library like jQuery to automatically add the token to all request headers. This provides simple, convenient CSRF protection for your AJAX based applications:

```
// you dont need this if you are using bootstrap that included this already.
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```



## User class in blade file

```
<p>Copyright &copy; qbnn.net {{\Carbon\Carbon::now()->year}}</p>
```



## Set uncheck foreign key

```php
DB::statement('SET FOREIGN_KEY_CHECKS=0')
```

