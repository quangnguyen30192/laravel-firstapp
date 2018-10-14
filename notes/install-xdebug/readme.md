# install automatically

## Prerequisites 

 apple command line tool

## Install xdebug

```
pecl install xdebug
```



this will create `xdebug.so` file

```bash
Build process completed successfully
Installing '/usr/local/Cellar/php/7.2.9_2/pecl/20170718/xdebug.so'
install ok: channel://pecl.php.net/xdebug-2.6.1
Extension xdebug enabled in php.ini
```



## check xdebug running:

```
php -m | grep xdebug
```



## Update php.ini within xdebug.so

Open `php.ini` file ( where you can get from phpinfo()): normally at `/etc/php.ini` in your server and add the below

```properties
zend_extension="/linkTo/xdebug.so"

xdebug.remote_enable=1

xdebug.remote_host=localhost

xdebug.remote_port=9000

xdebug.remote_autostart=1

xdebug.remote_mode=req

xdebug.profiler_enable=1

xdebug.profiler_output_dir=/tmp

xdebug.idkey=PHPSTORM 
```



# install manually

 https://xdebug.org/docs/install 

You can [download](https://xdebug.org/download.php#releases) the source of the latest **stable** release 2.6.0. Alternatively you can obtain Xdebug from GIT:

```
git clone git://github.com/xdebug/xdebug.git
```

## Compiling

## Prerequisites

phpize

## making xdebug.so

1. Go to the root of folder you've downloaded `cd xdebug` 

   ```bash
   cd xdebug
   ```

2. Run `phpize` to create `configure` file

   ```bash
   sudo phpize
   ```

3. Enable xdebug

   ```bash
   ./configure
   ./configure --enable-xdebug
   ```

4. Run make

5. Run make install

6. Get `xdebug.so` at `./modules/xdebug.so`



## Update php.ini within xdebug.so as auto approach



## Restart your webserver and check we have xdebug from phpinfo()

# Configure phpstorm

<http://laravelforbeginners.com/understanding-phpstorm-xdebug-2-ways-debug-laravel-app/>

