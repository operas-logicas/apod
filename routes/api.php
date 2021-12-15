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

    // posts/{id} GET
    Route::get('posts/{id}', [
        'uses' => 'PostApiController@show'
    ])->where('id', '^\d+$');

    // posts/{date} GET
    Route::get('posts/{date}', [
        'uses' => 'PostApiController@indexForDate'
    ])->where('date', '^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$');

    // posts
    Route::apiResource('posts', 'PostApiController');

    // users
    Route::apiResource('users', 'UserApiController');

    // users/login POST
    Route::post('users/login', [
        'uses' => 'UserApiController@login'
    ]);

    // users/logout POST
    Route::post('users/logout', [
        'uses' => 'UserApiController@logout'
    ]);

});
