<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    echo 'This is testing';
});

Route::any('/test/any', function () {
    return view('test');
});

Route::get('demo', function () {
    $channel = "my demo";
    $welcome = "welcome";
    return view('template.demo', compact('channel', 'welcome'));
});

Route::get('/user/create', [UserController::class, 'create']);
Route::get('/demo/invoke', [DemoController::class, '__invoke']);
Route::resource('post', TestController::class);
