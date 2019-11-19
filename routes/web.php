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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'Post\PostController@index');

Route::resource('posts', 'Post\PostController');

Route::resource('comments', 'Comment\CommentController');

Route::get('/follow/{userId}', 'Profile\ProfileController@follow');

Route::get('/unfollow/{userId}', 'Profile\ProfileController@unfollow');

Route::get('/{username}/following', 'Profile\ProfileController@following')->name('following');

Route::get('/{username}/followers', 'Profile\ProfileController@followers')->name('followers');

Route::get('/{username}', 'Profile\ProfileController@index');

