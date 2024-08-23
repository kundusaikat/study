<?php

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
    return view('template.demo', compact('channel','welcome'));
});
