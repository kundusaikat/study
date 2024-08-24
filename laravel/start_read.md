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

# 5 How to send Dynamic Data in blade file

Route::get('demo', function () {
    $channel = "my demo";
    $welcome = "welcome";
    return view('template.demo', compact('channel','welcome'));
});

# 6 What is controller & how to create

Controller=>

What Is Controller.
- A controller is the C in the MVC.
- The controller is where you enter or code most of your application logic
- Controllers can group related request handling logic into a single class
- For example, a UserController class might handle all incoming requests related to users, including showing, creating, updating, and deleting users

-> Path
app/Http/Controllers

Types Of Controller And Command
- Basic Controller - php artisan make:controller UserController
- Single Action Controller - php artisan make:controller UserController --invokable
- Resource Controller - php artisan make:controller UserController -r

Create Controller Command

GET	/photos	index	photos.index
GET	/photos/create	create	photos.create
POST	/photos	store	photos.store
GET	/photos/{photo}	show	photos.show
GET	/photos/{photo}/edit	edit	photos.edit
PUT/PATCH	/photos/{photo}	update	photos.update
DELETE	/photos/{photo}	destroy	photos.destroy

# 7 What is migration and how to create
php artisan make:migration create_admins_table
path --> app/data/migration