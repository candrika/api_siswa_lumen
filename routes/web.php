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

//crud simple taks
//login dan register
$router->post('/login','UserController@login');
$router->post('/register','UserController@register');
// $router->post('/sendResetMail','UserController@sendResetMail');
$router->put('/verifyResetPassword/{token}','UserController@verifyResetPassword');


//authentification activited
$router->group(['middleware'=>'auth'],function() use($router){
	//admin/guru/staf
	$router->get('/index','UserController@index');
	$router->get('/edit/{id}','UserController@editUser');
	$router->put('/update/{id}','UserController@updateUser');
	$router->delete('/delete/{id}','UserController@deleteUser');	

	//siswa
});
