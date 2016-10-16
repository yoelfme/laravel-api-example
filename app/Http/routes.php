<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('products/{id}', 'App\Http\Controllers\Api\V1\ProductController@show');
    $api->get('products', 'App\Http\Controllers\Api\V1\ProductController@index');
    $api->post('products', 'App\Http\Controllers\Api\V1\ProductController@store');
    $api->put('products/{id}', 'App\Http\Controllers\Api\V1\ProductController@update');
    $api->delete('products/{id}', 'App\Http\Controllers\Api\V1\ProductController@destroy');
});