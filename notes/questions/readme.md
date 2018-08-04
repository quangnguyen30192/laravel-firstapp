### Questions

### ✅ **Vấn đề N + 1 và Eager Loading**

Hãy giả sử bạn gặp một vấn đề như thế này:

- Bạn có một danh sách các bài viết trong bảng posts, với Model Eloquent tên là Post
- Mỗi Post thuộc về một User. Post có quan hệ belongsTo với User, và User có quan hệ hasMany với Post.
- Bạn có một trang Post list, cần hiển thị ra một danh sách các Post, dĩ nhiên với tên tác giả của post đó. Đây là một tình huống rất hay thường gặp trong các project, với nhiều biến thể khác nhau. Và dưới đây là một cách giải quyết thường gặp.

```
// Post Model

public function user()

{

    return $this->belongsTo(User::class);

}

// In Controller or Somewhere else

$posts = Post::all();

// View

foreach ($posts as $post) {

    {{ $post->title }}

    {{ $post->user->name }}

}
```



- Như vậy để in ra tên của chủ nhân của bài viết, ta đã sử dụng đến quan hệ user mà mình đã định nghĩa, tức nó sẽ lấy ra User chủ nhân của bài Post. Nếu bạn cài Laravel Debugbar thì bạn sẽ nhận ra những vấn đề của phương pháp này:

- - Với mỗi một bài Post ta phải thực hiện một câu truy vấn SQL để lấy ra User. Nếu số lượng bài post của bạn là lớn thì số lượng câu truy vấn SQL phải thực cũng sẽ là lớn.
  - Có khả năng bị thực hiện những câu truy vấn trùng lặp nhau. Chẳng hạn bài post số 1, 2, 3 đều thuộc user có id là 1. Trong trường hợp đó ta sẽ phải thực hiện 3 câu truy vấn SQL cùng với mục đích là lấy ra user có id bằng 1 (để gán vào cho từng bài post).

Nên biết truy vấn SQL thường là một trong những tác vụ tốn nhiều thời gian nhất trong một xử lý request. Rõ ràng việc phải sử dụng nhiều câu truy vấn như vậy là một vấn đề ta cần khắc phục. Ta gọi vấn đề đó là N + 1 problem, bởi ngoài việc dùng 1 câu truy vấn để select ra N bài post, bạn sẽ phải sử dụng tiếp N câu truy vấn để lấy ra N user cho N bài post đó.

Laravel cung cấp một công cụ để giải quyết vấn đề này, đó là **Eager Loading**.

```php
// Eager Loading
$posts = Post::with('user')->all();

// Lazy Eager Loading
$posts = Post::all();
$posts->load('user');
```

Với việc sử dụng hàm with() hay load(), ta có thể load một lúc ra tất cả các User thuộc về tất cả các Post chỉ bằng một câu truy vấn SQL. Điều này sẽ giúp ta giảm số lượng câu truy vấn đi một cách đáng kể.

Hãy luôn cố gắng dùng Eager Loading những lúc có thể nhé. Laravel cung cấp cho chúng ta một hệ thống Eager Loading rất hoàn hảo và mạnh mẽ. Bên cạnh việc load một quan hệ như trên, ta còn có thể **load một lúc nhiều quan hệ (Multiple Relationships Eager Loading)**, **load quan hệ chồng nhau (Nested Eager Loading)**, hay **thực hiện Eager Loading có kèm điều kiện** ...

### ✅ Thin/Fat controller

- https://matthewdaly.co.uk/blog/2018/02/18/put-your-laravel-controllers-on-a-diet/
- https://laracasts.com/discuss/channels/laravel/model-function-to-make-controller-skinny
- https://github.com/alexeymezenin/laravel-best-practices#fat-models-skinny-controllers

```php
// Assuming User model

// Ensure password is always encrypted without having to specifically make sure each time
public function setPasswordAttribute($password)
{
    return $this->attributes['password'] = bcrypt($password);
}

public function insertUser($request)
{
    $user = $this; // $this refers to User Model Instance
        $user->user_type = $request->user_type;
        $user->username =  $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
    return $user;
    // or you can use create method here too if you wanted, or in a repository, job, event anywhere you use the User Model
    return $this->create($request->all());
}
```



### ✅ Difference between

- ```
  // this would drop all the tables and run the migrations
  php artisan migrate:fresh
  ```

  ```
  // this would rollback for every single table and run the migrations
  php aritsan migrate:refresh
  
  ```

### ✅ Is there any way to import dump data for tables  ?

using Seeder

https://toidicode.com/seeding-trong-laravel-18.html

### ✅ Eloquent soft delete - difference `withTrashed` and `all`

```
Students::withTrashed()->get(); -- would show students regardless delete_at column is null or not
Students::onlyTrashed()->get(); -- would show students whose delete_at column is not null

```

### ✅ Difference between: `Students::withTrashed()` and `Students::all()` ?

- `Students::all()`:  soft deleted rows will automatically be excluded from query results. it doesn't show soft deleted rows.

- `Students::withTrashed()`: inluded soft deleted rows in the query results

  

### ✅ What is the role of `middleware` in http folder ?

*Middleware is the middle layer between webserver and your service. It's suppose to apply the logic that  you want it happens before or after the request. - like callback function*

*it's about security features*



### ✅ There could be duplicated with routes - what would be call if there are 2 routes has same names and same method - get

*The last delaration will win*



### ✅ Difference between: 

```php
Route::get('/contact', function(){})
Route::get('contact', function(){})
```

*They are the same*



### ✅ Why do we have `routes` folder with api, channels, console, web ?

*it's about Soc (Separation of Concerns)*

*Concerns are the different aspects of software functionality. For instance, the "business logic" of software is a concern, and the interface through which a person uses this logic is another.*

*The separation of concerns is keeping the code for each of these concerns separate. Changing the interface should not require changing the business logic code, and vice versa.*

*Model-View-Controller (MVC) design pattern is an excellent example of separating these concerns for better software maintainability.*



### ✅ Mysql 8 connection problem:

- communication link failure
- request authentication method unknow to client (cache_rsha2_password)
- connection refused

**Way 1 :=> mariadb with docker**

*Use mariadb, set no password. Use docker if you can.*

1. *Install docker for mac*
2. *Run commands*

```
docker rm -v mariadb
docker run -p "3306:3306" -e MYSQL_ALLOW_EMPTY_PASSWORD=1 --name mariadb -d mariadb

```

lệnh dưới tạo ra 1 container chạy maria db, attach vào port 3306 => nếu e đã cài mysql thì gỡ mysql của e ra để khỏi xung đột port

MYSQL_ALLOW_EMPTY_PASSWORD=1 => means ko cần password, sử dụng uname = root, password =

e đưa e lệnh đó vào 1 file shell, sau này chỉ cần chạy docker trước, rồi chạy file shell đó thôi

**Way 2 :=> Re-install xampp with the version without VM**

**Way 3 :=> Use previous version of mysql: 5 or 7.2**



### ✅ Difference route and url helper function

- The `route` helper function uses the route name. If you change your URL for some reason in the future, the `route` helper function will reflect that as long as the name of the route remains the same.

- You can also easily pass parameters to the route() helper, making it easy to do URIs like /user/2/edit by doing

  ```
  route('user.edit', [$user->id])
  ```

  You cant do that with url() (yes with string concatenation)

- more over, you can treat one as end user facing (url) and other as application facing. You can have as absurd (but convenient) as possible name route

  ```
  route('my.absurd.route') 
  ```

  which then translates to /welcome. but with url you don't get this facility.