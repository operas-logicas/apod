<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// index GET
Route::get('/', [
    'uses' => 'PostController@getIndex',
    'as' => 'index'
]);

// about GET
Route::get('/about', function() {
    return view('about');
})->name('about');

// admin GROUP
Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth'
], function() {

    // admin/posts GROUP
    Route::group([
        'prefix' => 'posts'
    ], function() {
        // admin/posts GET
        Route::get('', [
            'uses' => 'PostController@getAdminIndex',
            'as' => 'posts.index'
        ]);

        // admin/posts/create GET
        Route::get('create', function() {
            return view('admin.posts.create');
        })->name('posts.create');

        // admin/posts/edit GET
        Route::get('edit', function() {
            return view('admin.posts.edit');
        })->name('posts.edit');
    });

    // admin/users GROUP
    Route::group([
        'prefix' => 'users',
    ], function() {
        // admin/users GET
        Route::get('', [
            'uses' => 'UserController@getIndex',
            'as' => 'users.index'
        ]);

        // admin/users/create GET
        Route::get('create', function() {
            return view('admin.users.create');
        })->name('users.create');

        // admin/users/edit GET
        Route::get('edit', function() {
            return view('admin.users.edit');
        })->name('users.edit');
    });

});

Auth::routes();
