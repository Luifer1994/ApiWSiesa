<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use GuzzleHttp\Client;
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
    /* return $router->app->version(); */

    /*  $response = Http::get('https://jsonplaceholder.typicode.com/posts');
    return $response; */

    $client = new Client;
    $request = $client->get('https://jsonplaceholder.typicode.com/photos');

    $response = (string) $request->getBody();

    return json_decode($response);
});


$router->post('/clients', [
    'as' => 'clientes', 'uses' => 'ListUserController@ListUserForDocument',
]);
