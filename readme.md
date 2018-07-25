# Lavarel MVC

* Model: database objects

* View: html

* Controller: Middle-Man

  

# Environment Setup

* Lavarel 5.5 requires PHP 7+

* XAMPP or Lavarel Homestead or Laragon ? 

  * **XAMPP**: enable htdocs folder visible: Volumes -> Mount

    * ```bash
      alias htdocs="cd $USER/.bitnami/stackman/machines/xampp/volumes/root/htdocs"
      ```

  * Lavarel Homestead tutorial - [link](https://www.udemy.com/laravel-homestead/learn/v4/overview)

* [PhpStorm](https://trungit.com/cai-dat-va-active-phpstorm-20172-license-key.html)

* Packagist: php package repository - like java arifactory

* Composer: php package manager

  * Installation: https://getcomposer.org/download/

    * add into zshrc/bashrc:

    * ```
      export PATH="$PATH:$HOME/.composer/vendor/bin"
      ```

  * Grant global access

    ```bash
    mv ~/.composer.phar /usr/local/bin/composer
    ```

  * `htdocs` folder: Create a project

    * by composer

      ```
      composer create-project --prefer-dist laravel/laravel firstapp 5.5.28
      ```

    * by laravel installer

      ```
      composer global require "laravel/installer"
      lavarel new firstapp
      ```

    * grant access for storage folder after created

    * ```
      chmod -R o+wr firstapp/storage
      ```

  * show versions laravel/laravel from repository

  * ```bash
    composer info -a laravel/laravel
    ```

- Virtual Host ?

- Enable access phpmyadmin

  ```xml
  #etc/extra/httpd-xampp.conf
  <Directory "/opt/lampp/phpmyadmin">
      AllowOverride AuthConfig Limit
      Require all granted
      Order allow,deny
      Allow from all
      #Require local
      #ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
  </Directory>
  ```

  

# Lavarel Basic

## Framework Structure

* config/app.php: 

  * configuration: app name, env, locale, debug,...
  * import providers - 3rd apps

* config/database.php: database connection configuration

* `.env`: properties file, get value by function`env($key, $default = null)`

* vendor: dependencies installation folder

* app: events, exceptions, http, ...

* artisan: show available commands

  ```
  php artisan
  ```



## Routes

* routes/web.php

* Routes folder: `view` function mapping to resources/views/**.blade.php

  * e.g: route with path variables

  ```php
  Route::get('/students/{id}/{name}', function ($id, $name) {
      return "Hello student with id: ". $id ." - name: ". $name;
  });
  ```

* List all routes:

  ```
  php artisan route:list
  ```

* Naming a route

  ```php
  Route::get('/teachers', array('as' => 'admin.home', function () {
      $url = route('admin.home');
  
      return "your url: " . $url;
  }));
  ```

- Docs: https://laravel.com/docs/5.5/routing



## Controller

* Create a controller: 

  * Normal controller

    ```php
    php artisan make:controller StudentsController
    ```

  * Controller for show, update, edit, store,... :

    ```php
    php artisan make:controller --resource StudentsController
    ```

* Mapping a route to controller method

  ```php
  Route::get('/student', 'StudentsController@index');
  ```

* Passing & retriving data

  ```php
  Route::get('/student/{id}', 'StudentsController@index');
  
  ....
  class StudentsController {
      public function index($id) {
  
      }    
  }
  ```

* Resource route: generate full REST-API: GET-index, GET-create, GET-show, GET-edit, POST, PUT/PATH,  DELETE methods by just a single line of code.

  ```php
  Route::resource('/student', 'StudentsController');
  ```

* Docs: https://laravel.com/docs/5.5/controllers



## View

* Blade file: template engine

* Create a custom view and custom method

  * Add a method in the controller
  * Add a route for that method in `routes/web.php`
  * Create blade php file in `resources/views`

* Passing data to views

  * web.php

    ```php
    Route::get('/contact/{name}', 'StudentsController@contactStudent');
    ```

  * Controller

    ```php
    public function contactStudent($name)
    {
    	return view('pages.contact-student')->with('name', $name);
    	
    	# or
    	# return view('pages.contact-student', compact('name'));
    }
    ```

  * View

    ```php
    <h1>Hello {{$name}}</h1>
    ```

* Docs: https://laravel.com/docs/5.5/views



### Create master layout

* create layouts/app.blade.php: @yield('content'), @yield('footer')
* using: 
  * @extends('layouts.app') 
  * @section('content') ... @stop

### Blade template engine

```php
    @if(count($people))
        <ul>
            @foreach($people as $person)
                <li>{{$person}}</li>
            @endforeach
        </ul>
    @endif
```

* Docs: https://laravel.com/docs/5.5/blade

# Database

## Database migration

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

* ```
  php artisan make:migration create_students_table --create="students"
  ```

* create a migration with table editing

  ```
  php artisan make:migration add_name_column_in_students_table --table="students"
  ```

* Docs: https://laravel.com/docs/5.5/migrations



## Raw SQL queries

### Insert queries

```
DB:insert('insert into student(f_name, l_name) values(?, ?)', ['Quang', 'Nguyen']);
```

### Select queries

```php
$students = DB:select('select * from student where id = ?', [1]);

foreach($students as $student) {
    
}

return $students // return json

return var_dumps($students); // debug purpose
```

* Docs: https://laravel.com/docs/5.2/database



## Eloquent



# Questions

- Middleware in folder http

- There could be duplicated with routes

- Difference between: 

  ```php
  Route::get('/contact', function(){})
  Route::get('contact', function(){})
  ```

- Why do we have `routes` folder with api, channels, console, web ?

# Setup project

```
composer install

chmod -R o+rw storage

composer run post-root-package-install

composer run post-create-project-cmd

npm install
```

