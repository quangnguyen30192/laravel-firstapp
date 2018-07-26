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

  ## How to fix common errors ?

- Unable to access phpmyadmin ? Enable access phpmyadmin

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

- Got forbidden access ?

  - sure that  this is not enable

  - ```
    # Virtual hosts
    #Include etc/extra/httpd-vhosts.conf
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

  ```
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

* Create a model:

  * ```
    php artisan make:model Student
    ```

* List objects

  * ```
    Student::all();
    ```

* Find and order

  * ```
    Student::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
    ```

    

# Questions

- **[solved]** What is the role of `middleware` in http folder ?

  *Middleware is the middle layer between webserver and your service. It's suppose to apply the logic that  you want it happens before or after the request. - like callback function*

  

- **[solved]** There could be duplicated with routes - what would be call if there are 2 routes has same names and same method - get

  *The last delaration will win*

  

- **[solved]** Difference between: 

  ```php
  Route::get('/contact', function(){})
  Route::get('contact', function(){})
  ```
  *They are the same*

  

- **[solved]** Why do we have `routes` folder with api, channels, console, web ?

  *it's about Soc (Separation of Concerns)*

  *Concerns are the different aspects of software functionality. For instance, the "business logic" of software is a concern, and the interface through which a person uses this logic is another.*

  *The separation of concerns is keeping the code for each of these concerns separate. Changing the interface should not require changing the business logic code, and vice versa.*

  *Model-View-Controller (MVC) design pattern is an excellent example of separating these concerns for better software maintainability.*

  

- **[solved]** Mysql 8 connection problem:

  - communication link failure
  - request authentication method unknow to client (cache_rsha2_password)

  *Use mariadb, set no password. Use docker if you can.*

  1. *Install docker for mac*
  2. *Run commands*

  ```
  docker rm -v mariadb
  docker run -p "3306:3306" -e MYSQL_ALLOW_EMPTY_PASSWORD=1 --name mariadb -d mariadb
  ```



# Setup project

```
composer install

chmod -R o+rw storage

composer run post-root-package-install

composer run post-create-project-cmd

npm install
```

