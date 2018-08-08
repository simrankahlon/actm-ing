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

Route::get('/home', 'HomeController@index')->name('home')->middleware('revalidate');
Route::get('/home/changepassword', 'ChangePasswordController@show')->middleware('revalidate');
Route::post('/home/changepassword', 'ChangePasswordController@validatepassword')->middleware('revalidate');


//POSTS ROUTES

//Add Post Route
Route::get('/posts/create','PostsController@create')->middleware('revalidate');
Route::post('/posts/create','PostsController@store')->middleware('revalidate');

//List Individual Posts Route
Route::get('/posts','PostsController@list')->middleware('revalidate');

//Edit Post Route
Route::get('/posts/{post}/edit','PostsController@edit')->middleware('revalidate');
Route::post('/posts/{post}/edit','PostsController@update')->middleware('revalidate');


Route::get('/posts/{post}/delete','PostsController@delete')->middleware('revalidate');

