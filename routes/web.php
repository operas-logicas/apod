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
    'uses' => 'PostViewController@getIndex',
    'as' => 'index'
]);

// about GET
Route::get('/about', function() {
    return view('about');
})->name('about');

// admin GET
Route::get('/admin', function() {
    return redirect('admin/posts');
});

// index/post GET
Route::get('/posts/{id}', [
    'uses' => 'PostViewController@getPost',
    'as' => 'index.post'
]);

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
            'uses' => 'PostViewController@getAdminIndex',
            'as' => 'admin.posts.index'
        ]);

        // admin/posts/create GET
        Route::get('create', [
            'uses' => 'PostViewController@getAdminCreate',
            'as' => 'admin.posts.create'
        ]);

        // admin/posts/create POST
        Route::post('create', [
            'uses' => 'PostViewController@postAdminCreate',
            'as' => 'admin.posts.create'
        ]);

        // admin/posts/edit GET
        Route::get('edit/{id}', [
            'uses' => 'PostViewController@getAdminEdit',
            'as' => 'admin.posts.edit'
        ]);

        // admin/posts/edit POST
        Route::post('edit', [
            'uses' => 'PostViewController@postAdminUpdate',
            'as' => 'admin.posts.update'
        ]);

        // admin/posts/delete GET
        Route::get('delete/{id}', [
            'uses' => 'PostViewController@getAdminDelete',
            'as' => 'admin.posts.delete'
        ]);

        // admin/posts/date GET
        Route::get('{date}', [
            'uses' => 'PostViewController@getAdminIndex',
            'as' => 'admin.posts.index.date'
        ]);

    });

    // admin/users GROUP
    Route::group([
        'prefix' => 'users',
    ], function() {

        // admin/users GET
        Route::get('', [
            'uses' => 'UserController@getUserIndex',
            'as' => 'admin.users.index'
        ]);

        // admin/users/create GET
        Route::get('create', [
            'uses' => 'UserController@getUserCreate',
            'as' => 'admin.users.create'
        ]);

        // admin/users/create POST
        Route::post('create', [
            'uses' => 'UserController@postUserCreate',
            'as' => 'admin.users.create'
        ]);

        // admin/users/edit GET
        Route::get('edit/{id}', [
            'uses' => 'UserController@getUserEdit',
            'as' => 'admin.users.edit'
        ]);

        // admin/users/edit POST
        Route::post('edit', [
            'uses' => 'UserController@postUserUpdate',
            'as' => 'admin.users.update'
        ]);

        // admin/users/delete GET
        Route::get('delete/{id}', [
            'uses' => 'UserController@getUserDelete',
            'as' => 'admin.users.delete'
        ]);

    });

});

Auth::routes();

// index/date GET
Route::get('/{date}', [
    'uses' => 'PostViewController@getIndex',
    'as' => 'index.date'
]);
