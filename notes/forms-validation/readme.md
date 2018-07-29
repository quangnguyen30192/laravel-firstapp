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