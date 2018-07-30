### Install xdebug

```
pecl install xdebug
```



### check xdebug running:

```
php -m | grep xdebug
```



### Update php.ini

Open `php.ini` file (phpinfo()): normally at `xamppfiles/etc/php.ini` and add the below

```properties
zend_extension="/Users/qnguyen/Downloads/xdebug/modules/xdebug.so"

xdebug.remote_enable=1

xdebug.remote_host=localhost

xdebug.remote_port=9000

xdebug.remote_autostart=1

xdebug.remote_mode=req

xdebug.profiler_enable=1

xdebug.profiler_output_dir=/tmp

xdebug.idkey=PHPSTORM 
```



### Download xdebug modules and update zend_extension in php.ini

Download xdebug modules: https://xdebug.org/docs/install 

#### Installation on Mac OS X

PHP is available from the unofficial Mac OS X package manager [Homebrew](http://brew.sh/). Homebrew recommend using PECL to install Xdebug, so please follow the instructions above for [installing via PECL](https://xdebug.org/docs/install#pecl).

#### Installation From Source

You can [download](https://xdebug.org/download.php#releases) the source of the latest **stable** release 2.6.0. Alternatively you can obtain Xdebug from GIT:

```
git clone git://github.com/xdebug/xdebug.git
```

This will checkout the latest development version which is currently 2.7.0alpha1. You can also browse the source at <https://github.com/derickr/xdebug>.

#### Compiling

There is a [wizard](https://xdebug.org/wizard.php) available that provides you with the correct file to download, and which paths to use.

You compile Xdebug separately from the rest of PHP. Note, however, that you need access to the scripts 'phpize' and 'php-config'. If your system does not have 'phpize' and 'php-config', you will need to compile and install PHP from a source tarball first, as these script are by-products of the PHP compilation and installation processes. (Debian users can install the required tools with `apt-get install php5-dev`). It is important that the source version matches the installed version as there are slight, but important, differences between PHP versions. Once you have access to 'phpize' and 'php-config', do the following:

1. Unpack the tarball: tar -xzf xdebug-2.6.0.tgz. Note that you do not need to unpack the tarball inside the PHP source code tree. Xdebug is compiled separately, all by itself, as stated above.
2. cd xdebug-2.6.0
3. Run phpize: phpize (or /path/to/phpize if phpize is not in your path). Make sure you use the phpize that belongs to the PHP version that you want to use Xdebug with. See this [FAQ entry](https://xdebug.org/docs/faq#api) if you're having some issues with finding which phpize to use.
4. ./configure --enable-xdebug
5. make
6. make install

### Configure PHP to Use Xdebug

1. add the following line to php.ini: zend_extension="/wherever/you/put/it/xdebug.so". For PHP versions earlier than 5.3 **and** threaded usage of PHP (Apache 2 worker MPM or the ISAPI module), add: zend_extension_ts="/wherever/you/put/it/xdebug.so" instead. **Note:** In case you compiled PHP yourself and used --enable-debug you would have to use zend_extension_debug=. **Note:** If you want to use Xdebug and OPCache together, you must load Xdebug after OPCache. Otherwise, they won't work properly. **From PHP 5.3 onwards, you always need to use the zend_extension PHP.ini setting name, and not zend_extension_ts, nor zend_extension_debug. However, your compile options (ZTS/normal build; debug/non-debug) still need to match with what PHP is using.**
2. Restart your webserver.
3. Write a PHP page that calls '*phpinfo()*' Load it in a browser and look for the info on the Xdebug module. If you see it next to the Zend logo, you have been successful! You can also use 'php -m' if you have a command line version of PHP, it lists all loaded modules. Xdebug should appear twice there (once under 'PHP Modules' and once under 'Zend Modules').



* update zend_extension=/Users/qnguyen/Downloads/xdebug/modules/xdebug.so is in `modules` folder after extracted



### Configure phpstorm

<http://laravelforbeginners.com/understanding-phpstorm-xdebug-2-ways-debug-laravel-app/>