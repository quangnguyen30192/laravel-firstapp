## Forms and validation

##  Get input information from a request



PostController

```php
public function store(Request $request)
{
    return $request->all(); // dd($request->all());
    
    // get a specific parameter
    $title = $request->get('tittle');
    
    // or
    $title = $request->title;
}
```



## CSRF field

if you get a TokenMismatchException/the page has expired due to inactivity -  error then put `{{csrf_field()}}` inside your form below title input

`{{csrf_field()}}` would generate the below into your form

```html
<input type="hidden" name="_token" value="jq01SCLlG9EKDm68qQWj4x6kIV60gvX7YWy8Xc7W">
```



## Persiting data into database

```php
Post::create($request->all());

// or

$post = new Post;
$post->title = $request->title;
$post->save();
```



## Interpolate route path

```
{{route('posts.index')}}

//with parameter
{{route('posts.index', $post->id)}}
```



## Redirect in controller

```
redirect(route('posts.index'));
```



## Using PUT method in form html

Forms only support GET and POST, in order to use PUT method then put the below in your form

```html
<input type="hidden" name="_method" value="PUT">
```



## CSRF

**CSRF** là viết tắt của từ "**C**ross-**S**ite **R**equest **F**orgery", đây là một kỹ thuật tấn công sử dụng quyền chứng thực của người dùng để thực hiện các hành động trên một website khác.

-Kỹ thuật này được xuất hiện lần đầu tiên vào năm 1990 nhưng nó chưa được phát hiện một cách trực tiếp, cho đến năm 2007 trở đi thì nó mới nổi lên rầm rộ (vụ hơn 18tr người dùng ebay tại hàn quốc bị lộ thông tin các nhân).

. Kỹ thuật này được nhận xét là khá nguy hiểm và hậu quả mà nó gây ra không thể kể đến được :D. Và cũng chính các ông lớn như Youtube, facebook,.. cũng đã từng dính phải các lỗi này.

![CSRF](https://toidicode.com/upload/images/php-optimize/CSRF.png)

###  2, Các hình thức tấn công.

-Như các bạn đã biết, thì các ứng dụng website đều thực hiện giao thức HTTP để nhận yêu cầu từ người dùng để thự thi các lệnh tương ứng. Và dựa vào cách này thì các Hacker có thể nhúng kèm vào một số request đến các ứng dụng web khác khi bạn vào một website có chứa **mã độc.**

Hãy tưởng tượng bạn đang làm admin của một website nào đó chẳng hạn, mà khi đó bạn đang chưa logout ra khỏi hệ thống quản trị (phiên làm việc vẫn còn) và bạn đi sang một diễn đàn khác đọc tin tức hay làm gì đó. Khi này hacker có thể chèn một mã độc dạng như sau để có thể thực thi một vài hành động trên trang web của bạn (ở đây mình demo là xóa tất cả bài viết):

```
<img src="http://example.com/delete/all_post" heigth="0" width="0">
```

-Trường hợp trên sẽ hoàn toàn đúng nếu như bạn chưa đăng xuất ra khỏi hệ thống web của bạn.

Ngoài cách trên thì hacker có thể thực thi được CSRF qua các HTML tag sau nữa:

- Tag `iframe`:

```
<iframe src="http://examole.com/delete/all_post"></iframe>
```

- Tag `link`:

```
<link rel="stylesheet" type="text/css" href="http://examole.com/delete/all_post">
```

- Tag `script`:

```
<script src="http://examole.com/delete/all_post" type="text/javascript" charset="utf-8" async defer></script>
```

- `Css`:

```
<p style="background-image: url(http://examole.com/delete/all_post")"></p>
```

- Và vô vàn cách thức khác nữa...

### 3, Các cách phòng tránh.

-Tuy rằng lỗi này rất phổ biến, nhưng phòng trống nó lại rất đơn giản. Các bạn có thể phòng trống bằng các cách sau:

#### Phòng trống phía client

- Để phòng trống được cách này thì mỗi các nhân chúng ta nên đăng xuất ra khỏi các website quan trong khi không dùng đến, đặc biệt là các website lên quan đến tiền tệ.
- Không click vào các link lạ trên bất kỳ một trang web, gmail, facebook, ... nào.
- Trong khi thực hiện các giao dịch quan trọng thì không lên vào các trang web khác.
- ...

#### Phía Server

- Chúng ta có thể thực hiện xây dựng captcha cho các yêu cầu quan trọng.
- Sử dụng CSRF token để có thể xác nhận request hợp lệ ([xem csrf token trên PHP](https://github.com/thanhtaivtt/csrf-token)).
- Đối với các hệ thống quan trọng thì chúng ta nên thiết lập sẵn các ip được cho phép.



## Package installation - LaravelCollective

https://laravelcollective.com/docs/5.4/html

```
composer require "laravelcollective/html":"^5.4.0"
```

and do follow the next steps in docs

Perferct builtin form package should be used. It make our life easier.

```php
// {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT']) !!}
{!! Form::model($post, ['action' => ['PostController@update', $post->id], 'method' => 'PUT']) !!}
    <div class="form-group">
        {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
```



## Validation

add validation in Controller method

```php
$this->validate($request, [
   'title' => 'required|max:5',
]);
```



configure in web.php to provide authentication fearures of middleware

```php
Route::group(['middleware' => 'web'], function () {
    Route::resource('/posts', 'PostController');
});
```



show errors in the blade file

```php
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
```



### Advance validation

create a request to handler submitting parameters

```
php artisan make:request CreatePostRequest
```



Replace `Request` by `CreatePostRequest`

```php
public function store(CreatePostRequest $request)
{
    $post = new Post;
    $post->title = $request->title;
    $post->user_id = 1;
    $post->content = 'test';
    $post->save();

    return redirect(route('posts.index'));
}
```



Put your validation rules in `CreatePostRequest@rules` and let `CreatesPostRequest@authorize` return true to activate the validation

```php
public function authorize()
{
    return true;
}

public function rules()
{
    return [
        'title' => 'required|max:5'
    ];
}
```

### Docs: https://laravel.com/docs/5.5/validation

## Date

```
$date = new DateTime();
$date->format('m.d.Y');

Carbon::now()->addDays(10)->diffForHumans();

Carbon::now()->subMonth(5)->diffForHumans();

Carbon::now()->yesterday()->diffForHumans();
```



## Accessors

After pulling out from the database, the accessor would format the value of the attritbue before it comes to the client

E.g in User model

```php
public function getNameAttribute($value)
{
    return strtoupper($value); 
}
```



The name of the method should follow the convention **get**xxx**Attribute** (xxx is the attritube following camelcase: eg the attribute is first_name then method is getFirstNameAttritbute)



```php
// whenever we call $user->name would return the uppercase of the user name
$user->name; // QUANG not quang
```



## Mutators

The mutator would format the value of the attritube before saving into the database.

E.g in User model

```php
public function setNameAttribute($value)
{
    $this->attributes['name'] = strtoupper($value);
}
```



The name of the method should follow the convention setxxxAttribute (xxx is the attribute - the same as accessors)

```php
// whenever the user is saved then it triggers setNameAttribute first, format the value and then goes to the database

$user = User:find(1);
$user->name = "quang-nguyen";
$user->save(); // the name now would be "QUANG-NGUYEN" in the database. 
```

### Docs: https://laravel.com/docs/5.5/eloquent-mutators



## Forms Uploading files

* Enabling file upload into form: add `enctype="multipart/form-data"` into form by adding `'files' => true`

  ```php
  {!! Form::open(['method' => 'POST', 'action' => 'PostController@store', 'files' => true]) !!}
          <div class="form-group">
              {!! Form::file('file', ['class' => 'form-control']) !!}
          </div>
  {!! Form::close() !!}
  ```

* Get the file

  ```php
  $file = $request->file('file');
  ```

Move a file to a folder and get it later.

```
$name = $file->getClientOriginalName();
$file->move('images', $name); // would move img file into images folder - that would be created in public folder beforehand with `chmod -R o+wr images` 

```



Display img file

```php
// $img_file = "images/test.jpg"
<img src="{{asset($post->img_file)}}">
```

- Docs: https://laravel.com/docs/5.5/requests#files