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

* Get post via user

  ```
  User::find(1)->post;
  ```

* Inverse relationship: get user via post

  Post model  (Post table has user_id which is primary key of User table)

  ```php
  public function user()
  {
      return $this->belongsTo('App\User');
  }
  ```

  Get user via post

  ```php
  Post::find($id)->user;
  ```

* Create a post

  ```php
  $user->post()->save($post);
  //
  $user->post()->create(['title' => 'Laravel in action']);
  ```

  Creating and updating need to treat differently. So check the existence of company attribute first.

  ```php
  $user = User::with('company')->findOrFail(1);
  if ($user->company === null)
  {
      $company = new Company(['name' => 'Test']);
      $user->company()->save($company);
  }
  else
  {
      $user->company->update(['name' => 'Test']);
  }
  ```

  Note that `hasOne()` does not guarantee that you will have one-to-one relationship, it just telling Eloquent how to create query. It works even you have multiple `Company` refer to same `User`, in such case when you call `$user->company` you will get first `Company` in the result data set from database.

- Update

  ```php
  $address = Address::whereUserId(1)->first();
  // or Address::where('user_id', '=', 1)->first();
  $address->address = "address updated";
  $address->save();
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



Post model: (Post table has user_id which is primary key of User table)

```
public function user()
{
    return $this->belongsTo('App\User');
}
```



- Get posts via user

  ```
  User::find($1)->posts;
  ```

- Create a post

  ```php
  $post = new Post(['title' => 'I love laravel']);
  $user->posts()->save($post);
  // or
  $user->posts()->create(['title' => 'Laravel in action']);
  ```

- Update a post

  ```php
  $user->posts()->whereId(1)->update(['title' => 'I love laravel']);
  // remember to configure mass massignment on Post
  ```

- Delete a post

  ```php
  $user->posts()->whereId(1)->delete();
  ```

## Many to many

- Create pivot table (join table) for users table and roles table: 

  ***Convention:*** 

  * Users and roles has many to many relationship

  - Laravel's naming convention for pivot tables is singularized table names in alphabetical order separated by an underscore. So, if one table is `users`, and the other table is `roles`, the pivot table will be `role_user`, join columns will be `user_id` and `role_id`
  - Alphabet: A B C D E F G H I J K L M N O P Q R S T U V W X Y Z

  

  ```
  php arisan make:migration create_users_roles_table --create="role_user"
  ```

- E.g User has many roles and vice versa

  - find roles of a user

    User model

    ```php
    public function roles()
    {
        // by default the pivot table is role_user (ordered by alphabet), join column is user_id and role_id
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
        
        // then you just need
        return $this->belongsToMany('App\Role');
        
        // if you dont follow the convention then just specify the pivot table name
        // return $this->belongsToMany('App\Role', 'user_role');    
        // return $this->belongsToMany('App\Role', 'user_role', 'uuser_id', 'rrole_id');
    }
    ```

    

    Get roles of a user

    ```php
    $user = User::findOrFail($id);
    if ($user->has('roles')) {
        foreach ($user->roles as $role) {
            echo $role->name. "<br/>";
        }
    } else {
        echo "user has no roles"
    }
    ```

  - find users by of a role (inverse many to many relationship)

    Role model

    ```php
    public function users()
    {
        return $this->belongsToMany('App\User');
        // or you need user_role as pivot table - it should be role_user by default
        // return $this->belongsToMay('App\User', 'user_role');
    }
    ```

    ```php
    Role::find($id)->users;
    ```

    

- Access pivot table

  - Pivot table has name role_user

  - You can access pivot table via role model

    ```php
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



If a photo whose imageable_type is null and you want to assign

```
$photo = Photo::find(4); (this has no imagable_type)
$user->photos()->whereId(1)->save($photo); // the photo whose photo_id = 4 no has imagable_type='App\User'
```



Update

```
$user->photos()->whereId(1)->update([path => 'test.jpg']); 
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



Create

```php
$post = Post:create(['name' => 'laravel in action']);
$tag = Tag::create(['name' => 'PHP']);

$post->tags()->save($tag);
```



## Attach - Detach - Sync

​	These operations would interact with only pivot table

### Attach

​	Always create a new record in pivot table regardless the existing of that record.

```php
$user = User::find(1);
$user->roles()->attach(1); // this would be create user_id = 1, role_id=1 in pivot table role_user

$user->roles()->attach(new Role(['name' => 'administrator']))
```



### Detach

​	Delete the records in pivot table

```
$user->roles()->detach(1); // the records with user_id=1 and role_id=1 will be deleted
$user->roles()->detach(); // all the records in pivot table will be deleted
```



### Sync

​	Update the records in pivot table

```
$user->roles()->sync([1]); create/update role_id=1 where user_id=1 in pivot table and delete other records whose user_id=1 and role_id != 1

$user->roles()->sync([1,2,3]); there would be 3 records in pivot table (user_id=1 role_id=1,2,3) and other records whose user_id=1 and role_id not in (1,2,3) would be deleted. 
```



## Docs https://laravel.com/docs/5.5/eloquent-relationships

