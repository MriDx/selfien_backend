<?php

use Illuminate\Http\Request;

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

//Route::post('posts/{post}/favorite', 'PostController@favorite')->name('post.favorite');

Route::group(['as' => 'api.', 'namespace' => 'Api', 'middleware' => 'auth:firebase'], function () {
    Route::post('create_customer', 'UserProfileController@stripe_create_customer')->name('profile.stripe_create_customer');
    Route::post('ephemeral_keys', 'UserProfileController@ephemeral_keys')->name('profile.ephemeral_keys');
    Route::post('profile/payment', 'UserProfileController@create_payment')->name('profile.payment');

    Route::post('profile', 'UserProfileController@store')->name('profile.create');
    Route::get('profile/{userProfile}', 'UserProfileController@show')->name('profile.show');
    Route::get('profile/followers/{userProfile}', 'UserProfileController@followers')->name('profile.followers');
    Route::get('profile/following/{userProfile}', 'UserProfileController@following')->name('profile.following');
    Route::post('profile/search', 'UserProfileController@search')->name('profile.search');
    Route::post('profile/follow/{userProfile}', 'UserProfileController@follow')->name('profile.follow');
    Route::get('follow/suggestions', 'UserProfileController@followSuggestion')->name('profile.followsuggestions');

    Route::get('categories', 'CategoryController@index')->name('category.index');

    Route::get('posts', 'PostController@index')->name('post.index');
    Route::post('posts', 'PostController@store')->name('post.create');
    Route::get('posts/me', 'PostController@myposts')->name('post.myposts');
    Route::get('posts/{post}/show', 'PostController@show')->name('posts.show');
    Route::delete('posts/{post}/delete', 'PostController@destroy')->name('posts.destroy');
    Route::post('posts/{post}/like', 'PostController@like')->name('post.like');
    Route::post('posts/{post}/dislike', 'PostController@dislike')->name('post.dislike');
    Route::post('posts/{post}/favorite', 'PostController@favorite')->name('post.favorite');
    Route::post('posts/{post}/share', 'PostController@share')->name('post.share');
    Route::get('stories/users', 'PostController@storyUsers')->name('post.stories.users');
    Route::get('stories/users/{userProfile}', 'PostController@stories')->name('post.stories');

    Route::get('posts/{post}/comments', 'CommentController@index')->name('comment.index');
    Route::post('posts/{post}/comments', 'CommentController@store')->name('comment.create');
    Route::post('comments/{comment}/like', 'CommentController@like')->name('comment.like');
    Route::post('comments/{comment}/dislike', 'CommentController@dislike')->name('comment.dislike');



    //Route::get('activities', 'UserProfileController@activities')->name('activities.index');
    Route::get('activities', 'PostActivityController@index')->name('activities.index');
});
