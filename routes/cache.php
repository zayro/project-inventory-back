<?php

$router->group(['prefix' => 'cache'], function () {
    Route::get('indexCache', 'CacheController@index');
    Route::get('diagnostico', 'CacheController@diagnostico');
    Route::get('diagnosticoQuery', 'CacheController@diagnosticoQuery');
});
