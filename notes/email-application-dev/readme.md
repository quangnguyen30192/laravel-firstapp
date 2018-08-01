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

```php
// admin index page
public function index()
{
    $users = User::all();
    return view('admin.index', compact('users'));
}

...

return redirect('/admin'); // would go to index(), get $user and return index page
return redirect(view('admin.index')) // go to view('admin.index') without supplying $user as a parameter
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

