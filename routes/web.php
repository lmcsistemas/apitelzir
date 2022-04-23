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


//Tarifas
$router->get('/tariffs', 'TariffsController@index');
$router->get('/tariff', 'TariffsController@getTariffs');



//Planos
$router->get('/plans', 'PlansController@index');
$router->get('/plans/plan/{plan}', 'PlansController@getPlan');
$router->get('/plans/compute', 'PlansController@compute');