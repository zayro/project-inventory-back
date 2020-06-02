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

$router->group(['prefix' => 'query'], function () {

    Route::get('BuscarEmpleados/{nroidentificacion}', 'QueryController@BuscarEmpleados');
    Route::get('BuscarLiquidaciones/{nroidentificacion}', 'QueryController@BuscarLiquidaciones');
    Route::get('BuscarCertificaciones/{nroidentificacion}', 'QueryController@BuscarCertificaciones');

});



$router->group(['prefix' => 'proccess'], function () {


    Route::post('/create/invoice/', 'ProcessController@invoice');

});


