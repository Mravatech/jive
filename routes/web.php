<?php


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

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->post('/authenticate', function () use ($router) {
    // Start Output buffering
    ob_start();
    echo "Authenticate";
    // Return the Output Buffer
    return ob_get_clean();
});

$router->group(['middleware' => 'jive.auth'], function ($router) {

    $router->get('/users', 'UsersController@index');

});
