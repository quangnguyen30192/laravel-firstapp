## Eloquent ORM

- Create a model:

  ```
  php artisan make:model Student
  ```

- List objects

  ```
  Student::all();
  ```

- Find and order

  ```
  Student::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
  Student:find(1);
  ```

## The correct ways to user first() and check for a result:

```php
$user = User::where('mobile', Input::get('mobile'))->first(); // model or null
if (!$user) {
   // Do stuff if it doesn't exist.
}
```

​	

Other techniques (not recommended, unnecessary overhead):

```php
$user = User::where('mobile', Input::get('mobile'))->get();

if (!$user->isEmpty()){
    $firstUser = $user->first()
}
```

or

```php
try {
    $user = User::where('mobile', Input::get('mobile'))->firstOrFail();
    // Do stuff when user exists.
} catch (ErrorException $e) {
    // Do stuff if it doesn't exist.
}
```

or

```php
// Use either one of the below. 
$users = User::where('mobile', Input::get('mobile'))->get(); //Collection

if (count($users)){
    // Use the collection, to get the first item use $users->first().
    // Use the model if you used ->first();
}
```



## Create data with configuring mass assignment:

**Mass Assignment là gì?** Mass Assignment xuất phát từ ngôn ngữ Ruby on Rails, là tính năng cho phép lập trình một cách tự động gán các tham số của một HTTP request vào các biến hoặc đối tượng trong lập trình. Ví dụ: chúng ta có một form đăng ký người dùng như sau, các tên trường nhập liệu trùng với tên cột trong bảng users trong CSDL.

```html
  <form>
     <input name='username' type='text'>
     <input name='password' type='text'>
     <input name='email' type='text'>
     <input type=submit>
  </form>
```

Khi đó form này POST dữ liệu lên chúng ta có thể ghi dữ liệu này vào CSDL bằng đoạn code sau:

```php
$user = new User(Input::all());
```

Thật ngắn gọn và đơn giản đúng không, tính năng này gọi là Mass Assignment. Tuy nhiên, có một lỗ hổng bảo mật xảy ra, nếu một kẻ xấu gửi thêm dữ liệu user_type = ‘admin’, khi đó user mới được tạo sẽ có quyền admin, việc gắn thêm dữ liệu gửi lên server là rất đơn giản có thể thực hiện bằng các công cụ có sẵn trên trình duyệt như Chrome Developer Tools…

Để xử lý vấn đề lỗ hổng trong Mass Assignment, Laravel đưa ra thêm hai thuộc tính cho Model là $fillable và $guarded. Ví dụ:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'password', 'email'];
}
```

$fillable cho phép thiết lập các cột trong một bảng có thể sử dụng tính năng Mass Assignment, khi đó ta có thể thực hiện:

```php
$user = User::create(Input::all());
// Hoặc
$user = new User(Input::al());
// Hoặc
$user = new User(['name' => 'quang', 'password' => bcrypt('Secret', 'email' => 'quangbnn@gmail.com')])
```

Khi đó nếu kẻ xấu gửi thêm user_type là trường không có trong $fillable, các câu lệnh trên sẽ phát sinh một exception ngay. Như vậy lỗ hổng trong Mass Assignment đã được xử lý.

Trái ngược với `$fillable`, ta có thể định nghĩa các trường được bảo vệ khỏi Mass Assignment thông qua thuộc tính `$guarded`. **Chú ý, không khai báo cả hai thuộc tính này đồng thời.**

**Chú ý:** một vấn đề nữa là `$fillable` và `$guarded` chỉ có tác dụng với các phương thức của Eloquent Model, với các phương thức của Query Builder nó không có tác dụng. Ví dụ sau minh chứng cho điều này:

```php
// Phương thức Eloquent 
$user = User::find($id);
$user->update(Input::all());

// Phương thức Query Builder
User::where('id', $id)->update(Input::all());
```

Khi đó nếu kẻ xấu có tình chèn thêm user_type = ‘admin’ thì đoạn code đầu sẽ phát sinh exception còn đoạn code sau vẫn chạy bình thường.

## CRUD

- Create/Updae

  ```php
  $student = new Student;
  // or for find a existing student update: 
  // $student = Student::find(1);
  
  $student->firstname = "quang";
  $student->lastname = "nguyen";
  
  $student.save();
  
  // or 
      
  Student::create(['firstname' => 'quang', 'lastname' => 'nguyen']);
  Student::find(1)->update(['firstname' => 'minh']);
  ```

  

- Update

  ```php
  Students::where('id', 1)->update(['f_name'=> 'quang-update']);
  ```

- Delete

  ```php
  $student = Students::find(1);
  $student->delete();
  ```

  ```php
  Student::destroy(1);
  Student::destroy([2,3]);
  ```

  ```php
  Student:where('score, 10)->delete();
  ```

## Soft delete

- Model:

  ```php
  use SoftDeletes;
  protected $table = "students";
  protected $dates = ['detele_at'];
  ```

- Create migration to add delete_at column

  ```php
  up function: $table->softDeletes();
  down fucntion: $table->drop('delete_at');
  ```

- when you call delete() on a row then on that row, delete_at column would be  NOW() - the row would not disappear - if you want to permanently delete it then 

  ```php
  $student = Students::where('id', 3)->forceDelete();
  ```

- read soft delete

  ```php
  $student = Students::withTrashed()->where('id', 2)->get();
  ```

- show only trashed

  ```php
  $student = Students::onlyTrashed()->get();
  ```

- restore trashed

- ```php
  // set delete_at column is null
  $student = Students::withTrashed()->where('id', 2)->restore();
  $student = Students::where(id, 3)->restore();
  ```

- Docs: https://laravel.com/docs/5.5/eloquent

# 