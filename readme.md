# Table of contents

Inspired by Laravel [udemy course](https://www.udemy.com/php-with-laravel-for-beginners-become-a-master-in-laravel/learn/v4/t/lecture/4872796?start=0)

- [Studying progress](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/studying-progress) 

* [Laravel MVC - Basic - Environment](https://github.com/quangnguyen30192/laravel-firstapp)
* [Install xdebug](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/install-xdebug)
* [Database](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/database)

  * [Eloquent - ORM, Scope query](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/database/eloquent-orm)
  * [Eloquent - relationship](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/database/eloquent-relationship)
  * [Database - Tinker](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/database/tinker) - use Php Storm database (support for Ultimate version only) or seeders instead
  * [Forms and validation - package installation LaravelCollective - Date - Mutators - Accessors - Uploading files](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/forms-validation) 
  * [Form login - Middleware - Laravel Session](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/form-login-middleware-session)
  * [Email - Application - Dev](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/email-application-dev) 
* [Questions](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/questions)

Reference:

- [Awesome laravel](https://github.com/chiraggude/awesome-laravel/)

- [Collect.js](https://github.com/ecrmnn/collect.js/)

- [Laravel 5.5 - Collection](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Support/Collection.php#L394)

- [Laravel best practice - 1](http://www.laravelbestpractices.com/) 

- [Laravel best practice - 2](https://github.com/alexeymezenin/laravel-best-practices)

- https://www.phptherightway.com/

- More good articles

  - https://www.cloudways.com/blog/laravel-best-practices/

  - [laravel-the-right-way-best-practices](https://medium.com/@adebsalert/laravel-the-right-way-best-practices-2346cd6c5d89)

  - [Laravel Beauty: Recipes & Best Practices](https://viblo.asia/p/laravel-beauty-recipes-best-practices-6BAMYk9Evnjz#_van-de-n--1-va-eager-loading-7)

     

# Lavarel MVC

* Model: database objects

* View: html

* Controller: Middle-Man

  

# Environment Setup

* Lavarel 5.5 requires PHP 7+

* XAMPP or Lavarel Homestead or Laragon ? 

  * **XAMPP**: enable htdocs folder visible: Volumes -> Mount

     ```bash
      alias htdocs="cd $USER/.bitnami/stackman/machines/xampp/volumes/root/htdocs"
     ```

  * Lavarel Homestead tutorial - [link](https://www.udemy.com/laravel-homestead/learn/v4/overview)

* [PhpStorm](https://trungit.com/cai-dat-va-active-phpstorm-20172-license-key.html)

* Packagist: php package repository - like java arifactory

* Composer: php package manager

  * Installation: https://getcomposer.org/download/

    * add into zshrc/bashrc:

      ```bash
      export PATH="$PATH:$HOME/.composer/vendor/bin"
      ```

  * Grant global access

    ```bash
    mv ~/.composer.phar /usr/local/bin/composer
    ```

  * `htdocs` folder: Create a project

    * by composer

      ```bash
      composer create-project --prefer-dist laravel/laravel firstapp 5.5.28
      ```

    * by laravel installer

      ```
      composer global require "laravel/installer"
      lavarel new firstapp
      ```

    * grant access for storage folder after created

      ```bash
      chmod -R o+wr firstapp/storage
      ```

  * show versions laravel/laravel from repository

    ```bash
    composer info -a laravel/laravel
    ```

- Virtual Host: enter the website by `laravelfirstapp.dev` instead of `localhost/laravel-firstapp/public`

  - xamppfiles/etc/httpd.conf: enable `httpd-vhosts.conf`

    ```
    # Virtual hosts
    
    Include etc/extra/httpd-vhosts.conf
    ```

  - xamppfiles/etc/extra/httpd-vhost.conf

    replace the content with

    ```xml
    # localhost
    
    <VirtualHost *:80>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs"
        ServerName localhost
        ServerAlias www.localhost
    </VirtualHost>
    
    # laravelfirstapp.dev
    
    <VirtualHost *:80>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/laravel-firstapp/public"
        ServerName laravelfirstapp.dev
    </VirtualHost>
    ```

    

  - vim /etc/hosts

    ```
    127.0.0.1	laravelfistapp.dev
    ```

    

  

- How to fix common errors ?

  - Unable to access phpmyadmin ? Enable access phpmyadmin

    ```xml
    # etc/extra/httpd-xampp.conf
    <Directory "/opt/lampp/phpmyadmin">
        AllowOverride AuthConfig Limit
        Require all granted
        Order allow,deny
        Allow from all
    # Require local
    # ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
    </Directory>
    ```

  - Your connection is private on Chrome ?

    use FireFox

  - Got forbidden access ?

    - sure that  this is not enable

  - ```
    # Virtual hosts
    #Include etc/extra/httpd-vhosts.conf
    ```

# For debug

```
return $var; //json output
```

```php
var_dumps($var); 
```

```php
dd($var);
```

```php
dump($var);
```

* [Install xdebug](https://github.com/quangnguyen30192/laravel-firstapp/tree/master/notes/install-xdebug)

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
  * @section('content') ... @endsection

### Blade template engine

```
@if(count($people))
    <ul>
        @foreach($people as $person)
            <li>{{$person}}</li>
        @endforeach
    </ul>
@endif
```



* Docs: https://laravel.com/docs/5.5/blade

# Setup project

```bash
composer install;

chmod -R o+rw storage;

composer run post-root-package-install;

composer run post-create-project-cmd;

npm install;
```



# Maintainance and live mode

```
php artisan down
php artisan up
```

