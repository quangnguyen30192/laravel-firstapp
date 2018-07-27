# Database migration

* Run migration that would call `up` function in every single migration in `database/migrations`

* `migrations` table would keep tracking what migrations have run, then they would not run again.

  * Check migrations status

    ```
    php aritsan migrate:status
    ```

* Each migration runs successfully would be create one record in `migrations` table, if it's rollback then that record would be taken out.

* `batch` column in `migrations`: indicates the order of migrations batch executing

* timestamps: create_at, update_at column

* migration (set 'strict' => false in database.php) 

  ```
  php artisan migrate
  ```

* create a migration with table creation

  ```
  php artisan make:migration create_students_table --create="students"
  ```

* create a migration with table editing

  ```
  php artisan make:migration add_name_column_in_students_table --table="students"
  ```

* Docs: https://laravel.com/docs/5.5/migrations



# DB seed

Generate dummy data

* Create a seed

  ```
  php artisan make:seed UsersDumpData
  ```

  UsersDumpData class would be created - add data creation code in `run` function

  ```
  DB::table('users')->insert([
      'name' => 'quang',
      'email' => str_random(10).'@gmail.com',
      'password' => bcrypt('secret'),
  ]);
  ```

* Add UsersDumpData into DatabaseSeeder

  ```
  php artisan db:seed --class=UsersDumpData
  ```

  or

  ```
  $this->call(UsersDumpData::class); // added in DatabaseSeeder@run
  ```

* execute DatabaseSeed

  ```
  php artisan db:seed
  ```

  

# Raw SQL queries

## Insert queries

```
DB:insert('insert into student(f_name, l_name) values(?, ?)', ['Quang', 'Nguyen']);
```

## Select queries

```php+HTML
$students = DB:select('select * from student where id = ?', [1]);

foreach($students as $student) {
    
}

return $students // return json

return var_dumps($students); // debug purpose
```

* Docs: https://laravel.com/docs/5.2/database



# Eloquent ORM

* Create a model:

  ```
  php artisan make:model Student
  ```

* List objects

  ```
  Student::all();
  ```

* Find and order

  ```
  Student::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
  Student:find(1);
  ```

* The correct ways to user first() and check for a result:

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

* Create/Update a new student

* ```php
  $student = new Student;
  // or for find a existing student update: 
  // $student = Student::find(1);
  
  $student->firstname = "quang";
  $student->lastname = "nguyen";
  
  $student.save();
  ```

* Create data with configuring mass assignment ?

* Update

  ```
  Students::where('id', 1)->update(['f_name'=> 'quang-update']);
  ```

* Delete

  ```
  $student = Students::find(1);
  $student->delete();
  ```

  ```
  Student::destroy(1);
  Student::destroy([2,3]);
  ```

  ```
  Student:where('score, 10)->delete();
  ```

* Soft delete

  * Model:

    ```
    use SoftDeletes;
    protected $table = "students";
    protected $dates = ['detele_at'];
    ```

  * Create migration to add delete_at column

    ```
    up function: $table->softDeletes();
    down fucntion: $table->drop('delete_at');
    ```

  * when you call delete() on a row then on that row, delete_at column would be  NOW() - the row would not disappear - if you want to permanently delete it then 

    ```
    $student = Students::where('id', 3)->forceDelete();
    ```

  * read soft delete

    ```
    $student = Students::withTrashed()->where('id', 2)->get();
    ```

  * show only trashed

    ```
    $student = Students::onlyTrashed()->get();
    ```

  * restore trashed

  * ```
    // set delete_at column is null
    $student = Students::withTrashed()->where('id', 2)->restore();
    $student = Students::where(id, 3)->restore();
    ```

* Docs: https://laravel.com/docs/5.5/eloquent

# Eloquent relationship

## One to one

E.g: User has one Post

User model

```
    public function post()
    {
        return $this->hasOne('App\Post');
    }
```

Get post via user

```
User::find(1)->post;
```

* Inverse relationship: get user via post

  Post model

* ```
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

```
public function posts()
{
    return $this->hasMany('App\Post');
}
```

Get posts via user

```
User::find($1)->posts;
```

# Many to many

* Create join table for users table and roles table: create users roles table

  ```
  php arisan make:migration create_users_roles_table --create="role_user"
  ```

* E.g User has many roles

  * find roles of a user

    User model

    ```
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    ```

    ```
    User::find($id)->roles;
    ```

  - find users by of a role

    Role model

    ```
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    ```

    ```
    Role::find($id)->users;
    ```

    

  