Laravel is a php web framework.
requirement

- php 
- xampp/wamp server  https://www.apachefriends.org/download.html
- composer  https://getcomposer.org/download/

# Notes: to install xampp - delete iis from windows features(control panel) and always run as administrator

To create

- composer create-project laravel/laravel example-app
  or global install Laravel and then create

- composer global require laravel/installer
- laravel new example-app

to run

- cd example-app
- php artisan serve
  to change the default port
- php artisan serve --port=8085

to create mysql database connection

- start mysql and apache in xampp
- go to http://localhost/phpmyadmin/index.php
- create database same named as .env in the laravel app in side navbar
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=example_app
  DB_USERNAME=root
  DB_PASSWORD=

command after changing root directory

- php artisan config:clear

/routes/web.php
Routing methods

- get - view
- post - store
- put - store
- patch - store/update
- delete - delete

Route::get('/test', function () {
return 'This is testing';
});

Route::any('/test/any', function () {
return 'This is testing1 for all methods';
});

for return view in resources
Route::any('/test/any', function () {
return view('test');
});

Two way to pass variable into view page
1. in `/routes/web.php`
Route::get('demo', function () {
    $channel = "my demo";
    return view('template.demo', compact('channel'));
});
then,
`<p>Welcome to {{ $channel }}</p>`
type it inside the view itself `/resources/views/template/demo.blade.php`

