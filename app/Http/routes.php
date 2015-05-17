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

// Route::get('/', 'WelcomeController@index');

Event::listen('illuminate.query', function($sql)
	{?>app/routes.php<?php
		var_dump($sql);}
);


Route::get('/', 'HomeController@index');
// Route::get('/klan', 'KlanController@index');
// Route::get('/budynek','BudynekController@index');
// Route::get('/jednostka','JednostkaController@index');
// Route::get('/poczta','PocztaController@index');
// Route::get('/poczta/create','PocztaController@create');
// Route::get('/klan/create','KlanController@create');
//Route::get('/mapa','MapaController@index');
//Route::get('/surowiec','SurowiecController@index');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('surowiec', ['middleware' => 'auth', 'uses' => 'SurowiecController@index']);
Route::get('/mapa',['middleware' => 'auth', 'uses' => 'MapaController@index']);
Route::get('/klan', ['middleware' => 'auth', 'uses' => 'KlanController@index']);
Route::get('/budynek',['middleware' => 'auth', 'uses' => 'BudynekController@index']);
Route::get('/jednostka',['middleware' => 'auth', 'uses' => 'JednostkaController@index']);
Route::get('/poczta',['middleware' => 'auth', 'uses' => 'PocztaController@index']);
Route::get('/poczta/create',['middleware' => 'auth', 'uses' => 'PocztaController@create']);
Route::get('/klan/create',['middleware' => 'auth', 'uses' => 'KlanController@index']);

Route::get('//{nazwa}',['middleware' => 'auth', 'uses' => 'HomeController@get_id_port']);
Route::get('/budynek/{nazwa}',['middleware' => 'auth', 'uses' => 'BudynekController@update']);
Route::get('/jednostka/{nazwa}',['middleware' => 'auth', 'uses' => 'JednostkaController@werbuj']);