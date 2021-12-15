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

// index/date GET
Route::get('/{date}', [
    'uses' => 'PostViewController@getIndexForDate',
    'as' => 'index.date'
])->where('date', '^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$');

// about GET
Route::get('/about', function() {
    return view('about');
})->name('about');

// admin GET
Route::get('/admin', function() {
    return redirect('admin/posts');
});

// index/posts/
Route::get('/posts', function() {
    return redirect('/');
});

// index/posts/{id} GET
Route::get('/posts/{id}', [
    'uses' => 'PostViewController@getPost',
    'as' => 'index.post'
])->where('id', '^\d+$');

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
            'as' => 'admin.posts.store'
        ]);

        // admin/posts/edit/{post_id} GET
        Route::get('edit/{id}', [
            'uses' => 'PostViewController@getAdminEdit',
            'as' => 'admin.posts.edit'
        ]);

        // admin/posts/edit POST
        Route::post('edit', [
            'uses' => 'PostViewController@postAdminUpdate',
            'as' => 'admin.posts.update'
        ]);

        // admin/posts/delete/{post_id} GET
        Route::get('delete/{id}', [
            'uses' => 'PostViewController@getAdminDelete',
            'as' => 'admin.posts.delete'
        ]);

    });

    // admin/users GROUP
    Route::group([
        'prefix' => 'users',
    ], function() {

        // admin/users GET
        Route::get('', [
            'uses' => 'UserViewController@getUserIndex',
            'as' => 'admin.users.index'
        ]);

        // admin/users/create GET
        Route::get('create', [
            'uses' => 'UserViewController@getUserCreate',
            'as' => 'admin.users.create'
        ]);

        // admin/users/create POST
        Route::post('create', [
            'uses' => 'UserViewController@postUserCreate',
            'as' => 'admin.users.store'
        ]);

        // admin/users/edit/{user_id} GET
        Route::get('edit/{id}', [
            'uses' => 'UserViewController@getUserEdit',
            'as' => 'admin.users.edit'
        ]);

        // admin/users/edit POST
        Route::post('edit', [
            'uses' => 'UserViewController@postUserUpdate',
            'as' => 'admin.users.update'
        ]);

        // admin/users/delete/{user_id} GET
        Route::get('delete/{id}', [
            'uses' => 'UserViewController@getUserDelete',
            'as' => 'admin.users.delete'
        ]);

    });

});

Auth::routes();
