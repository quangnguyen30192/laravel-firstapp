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

* create a migration with table altering

  ```
  php artisan make:migration add_name_column_in_students_table --table="students"
  ```

* create a migration within model

  ```
  php artisan make:model Student --migration (or -m)
  ```

* Docs: https://laravel.com/docs/5.5/migrations



# DB seed

Generate dummy data

* Create a seed

  ```php
  php artisan make:seed UsersDumpData
  ```

  UsersDumpData class would be created - add data creation code in `run` function

  ```php
  DB::table('users')->insert([
      'name' => 'quang',
      'email' => str_random(10).'@gmail.com',
      'password' => bcrypt('secret'),
  ]);
  ```

* Add UsersDumpData into DatabaseSeeder

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
