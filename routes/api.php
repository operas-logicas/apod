<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], function() {

    // users
    Route::resource('users', 'UserApiController', [
        'except' => ['create', 'edit']
    ]);

    // users/login POST
    Route::post('users/login', [
        'uses' => 'UserApiController@login'
    ]);

    // users/logout POST
    Route::post('users/logout', [
        'uses' => 'UserApiController@logout'
    ]);

});
