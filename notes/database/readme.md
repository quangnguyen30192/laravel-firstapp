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

* ```
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
