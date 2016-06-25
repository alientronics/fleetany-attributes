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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function ($app) {


    /* basic crud for keys */
    $app->get('keys/{company_id}/{entity_key}/{description}', 'KeyController@index');
    $app->get('key/{id}', 'KeyController@get');
    $app->post('key', 'KeyController@create');
    $app->put('key/{id}', 'KeyController@update');
    $app->delete('key/{id}', 'KeyController@delete');

    /* attribute types
    $app->get('types','TypesController@get');
    */

    /* list entity keys
    $app->get('keys/{entity_key}','EntityController@keys');
    */

    /* filter entity list, return entities ids
    $app->post('filter/{entity_key}','EntityController@filter');
    */

    /* crud for entity an attributes */
    $app->get('values/{entity_key}/{entity_id}', 'EntityValueController@get');
    $app->post('values/{entity_key}/{entity_id}', 'EntityValueController@set');
    /*
    $app->delete('value/{entity_key}/{entity_id}','EntityValueController@delete');
	*/

});
