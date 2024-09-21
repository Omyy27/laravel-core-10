<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {
    Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');
});
