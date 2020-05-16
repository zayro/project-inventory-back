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

$router->get('/testing', function () {
    return "pruebas";
});



$router->group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    /*
    $router->get('/{db}[/{table}]', function ($db, $table =  null)    {
        // Matches The "/admin/users" URL
        echo $db.'bien'.$table;
    });
    */

    /**
     * General Api
     */

    Route::get('/{db}/all/{table}', 'GeneralController@all');
    Route::get('/{db}/field/{table}/', 'GeneralController@field');
    Route::get('/{db}/filters/{table}/{field}/{condition}', 'GeneralController@filter');
    Route::get('/{db}/filter/{table}/', 'GeneralController@filter');

    Route::post('/{db}/select', 'GeneralController@select');
    Route::post('/{db}/upload', 'GeneralController@upload');
    Route::post('/{db}/uploadInsert', 'GeneralController@uploadInsert');


    Route::post('/{db}/create/', 'GeneralController@create');
    Route::post('/{db}/createAutoincrement/', 'GeneralController@create_autoincrement');
    

    Route::put('/{db}/edit/', 'GeneralController@edit');
    Route::delete('/{db}/destroy/', 'GeneralController@destroy');


    /**
     * Folders 
     */

    Route::post('/file/createFolder/', 'file@crear_carpeta');
    Route::post('/file/deleteFolder/', 'file@eliminar_carpeta');
    Route::get('/viewFolder', 'ViewFormatController@viewFolder');
   
});


$router->group(['prefix' => 'unsafe'], function () {


    Route::get('/{db}/all/{table}', 'GeneralController@all');
    Route::get('/{db}/field/{table}/', 'GeneralController@field');
    Route::get('/{db}/filters/{table}/{field}/{condition}', 'GeneralController@filter');
    Route::get('/{db}/filter/{table}/', 'GeneralController@filter');

    Route::post('/{db}/select', 'GeneralController@select');
    Route::post('/{db}/upload', 'GeneralController@upload');
    Route::post('/{db}/uploadInsert', 'GeneralController@uploadInsert');

    Route::post('/{db}/create/', 'GeneralController@create');

    Route::put('/{db}/edit/', 'GeneralController@edit');
    Route::post('/{db}/destroy/', 'GeneralController@destroy');

    Route::post('/file/createFolder/', 'file@crear_carpeta');
    Route::post('/file/deleteFolder/', 'file@eliminar_carpeta');
});


Route::post('/mail/send', 'MailController@send');
