<?php

$router->post(
    'auth/login',
    [
       'uses' => 'AuthController@authenticate'
    ]
);

Route::post('/auth/changePassword/', 'ProcessController@ChangePassword');

Route::post('/auth/check/', 'AuthController@Check');

/**
 * Company
 */

Route::post('/auth/login/company', 'AuthController@authenticate');
Route::post('/auth/changePassword', 'AuthController@changePassword');
Route::post('/auth/recoveryPassword', 'AuthController@recoveryPassword');

