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

//Add Idea Route
Route::get('/ideas/create','IdeasController@create')->middleware('revalidate');
Route::post('/ideas/create','IdeasController@store')->middleware('revalidate');

//List Individual Ideas Route
Route::get('/ideas','IdeasController@list')->middleware('revalidate');

//Edit Idea Route
Route::get('/ideas/{idea}/edit','IdeasController@edit')->middleware('revalidate');
Route::post('/ideas/{idea}/edit','IdeasController@update')->middleware('revalidate');

//Delete Idea Functionality
Route::get('/ideas/{idea}/delete','IdeasController@delete')->middleware('revalidate');

//Like Ideas.
Route::get('/ideas/{idea}/like','IdeasController@like')->middleware('revalidate');
//Dislike Ideas.
Route::get('/ideas/{idea}/dislike','IdeasController@dislike')->middleware('revalidate');

//View individual comment of user ideas.
Route::get('/ideas/{idea}/comments','IdeasController@viewComments')->middleware('revalidate');

//Add Comments.
Route::get('/ajax/comment/{comment}','CommentController@viewComment')->middleware('revalidate');
Route::post('/ajax/comment/{idea}','CommentController@addComment')->middleware('revalidate');


//Delete Comment
Route::get('comments/{comment}/delete','CommentController@deleteComment')->middleware('revalidate');


//Project Add.
Route::get('/projects/create','ProjectsController@create')->middleware('revalidate');
Route::post('/projects/create','ProjectsController@store')->middleware('revalidate');

//List Individual Ideas Route
Route::get('/projects','ProjectsController@list')->middleware('revalidate');

//Edit Project Route
Route::get('/projects/{project}/edit','ProjectsController@edit')->middleware('revalidate');
Route::post('/projects/{project}/edit','ProjectsController@update')->middleware('revalidate');

//Delete Idea Functionality
Route::get('/projects/{project}/delete','ProjectsController@delete')->middleware('revalidate');

//Users List
Route::get('/users','UserController@list')->middleware('revalidate','gateauth');


//Make Admim Ajax.
Route::get('/ajax/admin/{user}/{checked}','UserController@makeAdmin')->middleware('revalidate');


