## 	Eloquent relationship

## One to one

E.g: User has one Post

User model

```php
public function post()
{
    return $this->hasOne('App\Post');
}
```

Get post via user

```
User::find(1)->post;
```

- Inverse relationship: get user via post

  Post model

  ```php
  public function user()
  {
      return $this->belongsTo('App\User');
  }
  ```

  Get user via post

  ```
  Post::find($id)->user;
  ```

## One to many

E.g: User has many posts

User model

```php
public function posts()
{
    return $this->hasMany('App\Post');
}
```

Get posts via user

```
User::find($1)->posts;
```

## Many to many

- Create pivot table (join table) for users table and roles table: 

  ***Convention:*** 

  ​        -> A user has many roles, a role has many users.

  ​	-> you reate roles() method in User model with belongsToMany('App\Role')

  ​        -> table name should be ***role_user***

  

  ```
  php arisan make:migration create_users_roles_table --create="role_user"
  ```

- E.g User has many roles

  - find roles of a user

    User model

    ```php
    public function roles()
    {
        // by default the pivot table is role_user 
        return $this->belongsToMany('App\Role');
        
        // if you dont follow the convention then just specify the pivot table name
        // return $this->belongsToMany('App\Role', 'cus_role_user', 'user_id', 'role_id');    
    }
    ```

    ```php
    User::find($id)->roles;
    ```

  - find users by of a role (inverse many to many relationship)

    Role model

    ```php
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    ```

    ```php
    Role::find($id)->users;
    ```

    

- Access pivot table

  - Pivot table has name role_user

  - You can access pivot table via role model

    - ```php
      $roles = User::find($id)->roles;
      foreach ($roles as $role) {
          echo $role->pivot;
      }
      ```

      

## Has many through

E.g: 

- a country has many users
- a users has many posts

How do we get all the posts in a country by a single line of code ?

using has many through.

Country model

```php
public function posts()
{
    return $this->hasManyThrough('App\Post', 'App\User');
}
```



Behind the scene,  it would get all the users via **country_id**, and for every single user it would get all the posts via **user_id**. How does it know country_id and user_id to get ? here by default

```php
public function posts()
{
    // country_id and user_id would be 3rd and 4th parameters by default
    return $this->hasManyThrough('App\Post', 'App\User', 'country_id', 'user_id');
    
    // then the below is enough, Laravel is smart enough to know country_id and user_id
    return $this->hasManyThrough('App\Post', 'App\User');
    
    // if you have another name than country_id or user_id
    return $this->hasManyThrough('App\Post', 'App\User', 'the_country_id', 'the_user_id');
}
```



then it's easy to get all the posts of a country

```php
Country::find(1)->posts
```



## Polymorphic relation - one to many

E.g: 

- a post has many photos
- a user has many photos
- a title has many photos

That's called polymorphic relation - one  to many (one post or one user has many photos)

Instead of Photo table has 3 column_ids representing primary key of Post, User, Title. We just need to have 2 column 

- imageable_id: primary key of Post or User or Title
- imageable_type: enumaration of 'App\Post', 'App\User', 'App\Title'

then later on if we have that Country has many photos, then we dont need to create more columns. 

### Eloquent model configure

Photo model

```php
public function imageable() // refer to imageable_id, imageable_type
{
 // We do this because photo_id is from Photo table (primary key of Photo table) 
 // and it provides the value for imagable_id - imagable type - Photo model is morphed
    return $this->morphTo();
}
```

User and Post model

```php
public function photos()
{
// We do this because primary key of User or Posts is represented by imageable_id
    return $this->morphMany('App\Photo', 'imageable'); 
}
```

Get Photos via User or Post

```php
Post::find($postId)->photos;
User::find($userId)->photos
```



Get Post or User via Photos (inverse)

```php
$imageable = Photo::find($id);
echo $imageable->imageable_type. "<br/>";
echo $imageable;
```



## Polymorphic relation - many to many

E.g: 

* Post has many Tags (Post table.= post_id, name)
* Video has many Tags (Video table = video_id, name)
* Tag has many Videos, Posts (Tag table = tag_id, name)
* Taggable table: pivot table - include: tag_id, taggable_id (post_id or video_id), taggable_type (Post or Video).

That's called polymorphic relation - may  to many (many posts or many users have many tags and vice versa)

### Eloquent model configure

Tag model

```php
// we do this because tag_id is from Tag table (primary key of Tag table)
// and it provides the value for taggable_id - taggable_type - Tag model is morphed
public function posts()
{
    return $this->morphedByMany('App\Tag', 'taggable');
}

public function videos()
{
    return $this->morphedByMany('App\Video', 'taggable');
}
```



Post and Video model

```php
public function tags()
{
    // We do this because primary key of Post or Video is represented by taggable_id
    return $this->morphToMany('App\Tag', 'taggable');
}
```



Get tags by a post/video and vice versa

```
Post::find(1)->tags
Video:find(1)->tags
Tags:find(1)->videos
Tags:find(1)->posts
```

