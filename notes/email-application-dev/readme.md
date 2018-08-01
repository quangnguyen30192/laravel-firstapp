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



## Redirect

* In Controller: we use 
  * `return view` : forward to blade file
  *  `return redirect(route(''))`: redirect to Controller method

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
// it doesnt go to index() method then it might have errors -- e.g missing parameters
// we will have this in controller
return view('admin.index');

// from Controller we forward to admin/edit.blade.php within a parameter - user
return view('admin.edit', compact('user'));

```



* we dont use  `return route` in Controller

  ```php
  return route('users.index');
  
  // we use
  return redirect(route('users.index'));
  ```

* In blade we use `route`  to map Controller method - not `view`

  ```php
  <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
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