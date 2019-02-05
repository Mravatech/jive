<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\Users\RegistrationController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix'=>'api/v1'], function () use ($router) {
    $router->post('/users/registration', 'Users\RegistrationController@register');
});

$router->post('/auth/login', 'Auth\AuthController@userAuthenticate');