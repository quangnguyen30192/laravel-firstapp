## Database tinker

Tool to testing database queries

```bash
php artisan tinker

App\User:find(1)

App\User:whereId(1)->get();
```



write eloquent better, we could find errors here and fix 

## Sluggable

* Installation and configure: https://github.com/cviebrock/eloquent-sluggable

* Instead of 

  ```
  http://example.com/post/1
  http://example.com/post/2
  http://example.com/post/My+Dinner+With+Andr%C3%A9+%26+Fran%C3%A7ois
  ```

  we use sluggeable for this reason and keep the urls unique

  ```
  http://example.com/post/my-dinner-with-andre-francois
  http://example.com/post/my-dinner-with-andre-francois
  http://example.com/post/my-dinner-with-andre-francois-1
  http://example.com/post/my-dinner-with-andre-francois-2
  ```

* Changes: [git commit](https://github.com/quangnguyen30192/laravel-firstapp/commit/3e0c398350661bb276233d4669900c2770cc1cdf)

  * Add a column 'slug into the table with type string unique.



## Pagination

Controller 

```
$users = App\User::paginate(15);
```



View

```php
<div class="container">
    @foreach ($users as $user)
        {{ $user->name }}
    @endforeach
</div>

{{ $users->links() }}
```



#### Docs: https://laravel.com/docs/5.5/pagination