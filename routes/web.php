<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'bingo'], function () use ($router) {
    $router->get('call',  ['uses' => 'BingoController@call']);
    $router->get('cards/take',  ['uses' => 'BingoController@takeCard']);
    $router->get('cards/check/{id}',  ['uses' => 'BingoController@checkCard']);
    $router->get('cards/check-all',  ['uses' => 'BingoController@checkAll']);
    $router->get('reset',  ['uses' => 'BingoController@reset']);
});