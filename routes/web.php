<?php

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


/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    //Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');

    //User Profile
    Route::get('profiles', 'UserProfileController@index')->name('profiles');
    Route::get('profiles/{profile}', 'UserProfileController@show')->name('profiles.show');
    Route::get('profiles/{profile}/edit', 'UserProfileController@edit')->name('profiles.edit');
    Route::put('profiles/{profile}', 'UserProfileController@update')->name('profiles.update');
    Route::get('profiles/{profile}/delete', 'UserProfileController@destroy')->name('profiles.destroy');

    //Posts
    Route::get('posts', 'PostController@index')->name('posts');
    Route::get('posts/{post}', 'PostController@show')->name('posts.show');
    Route::get('posts/{post}/delete', 'PostController@destroy')->name('posts.destroy');

    //Posts Activity
    Route::get('activities', 'PostActivityController@index')->name('postactivities');
    Route::get('activities/{actvity}', 'PostActivityController@show')->name('postactivities.show');
    Route::get('activities/{actvity}/delete', 'PostActivityController@destroy')->name('postactivities.destroy');

    //Comments
    Route::get('comments', 'CommentController@index')->name('comments');
    Route::get('comments/{comment}', 'CommentController@show')->name('comments.show');
    Route::get('comments/{comment}/delete', 'CommentController@destroy')->name('comments.destroy');

    //Comments Activity
    Route::get('comment/activities', 'UserController@index')->name('commentsactivities');
});


Route::get('/', 'Auth\LoginController@showLoginForm');
