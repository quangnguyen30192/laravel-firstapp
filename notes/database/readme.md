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




# DB fake factory

To generate Fake data in Laravel 5.5, we will use a super library called Faker, you do not need to download it, it is already included in this version of the framework.

https://github.com/fzaninotto/Faker

In Laravel, creating a script of fake data is called "Factory", let's make our first factory!

## 1 - Open your terminal and create your first factory:

```
php artisan make:factory UserFactory --model=User
```

This command will generate a file called:

```
database/factories/UserFactory.php
```

## 2 - Open UserFactory.php

And modify this code as needed:

```php
<?php
use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->firstNameMale,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'town_id' => $random = rand(1,115),
        'activationtoken' => $faker->password,

    ];
});
```

You can find a list of variables/functions which are used in the Faker Library [here](https://github.com/fzaninotto/Faker):

## 3 - Testing: use tinker

```
php artisan tinker
factory(App\User::class, 10)->create();
```

## 4 - Apply

* Create a seed file

  ```
  php artisan make:seed UserDataSeed
  ```

* Open UserDataSeed

  ```
  factory(App\User::class, 10)->create();
  ```

* For create by relationship: e.g you have Post table - Use has many Posts and then you want for every single user created, they have one post belong to

  ```php
  factory('App\User', 10)->create()->each(function($user) {
     	$post = factory('App\Post')->make(); // make only create a new model instance, not save into the database while create() does both.
      $user->posts()->save($post); 
  });
  ```

* In case that there is an error related to unlocated name then just refreshing cache

  ```php
  php artisan clear-compiled
  composer dump-autoload
  php artisan optimize
  ```

  

* Then add the UserDataSeed into DatabaseSeed

* Docs: https://laravel.com/docs/5.5/database-testing#using-factories

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
