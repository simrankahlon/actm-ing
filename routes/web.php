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

Route::get('/home', 'HomeController@index')->name('home')->middleware('revalidate','gateauth');
Route::get('/home/changepassword', 'ChangePasswordController@show')->middleware('revalidate','gateauth');
Route::post('/home/changepassword', 'ChangePasswordController@validatepassword')->middleware('revalidate','gateauth');


//POSTS ROUTES

//Add Idea Route
Route::get('/ideas/create','IdeasController@create')->middleware('revalidate','gateauth');
Route::post('/ideas/create','IdeasController@store')->middleware('revalidate','gateauth');

//List Individual Ideas Route
Route::get('/ideas','IdeasController@list')->middleware('revalidate','gateauth');

//Edit Idea Route
Route::get('/ideas/{idea}/edit','IdeasController@edit')->middleware('revalidate','gateauth');
Route::post('/ideas/{idea}/edit','IdeasController@update')->middleware('revalidate','gateauth');

//Delete Idea Functionality
Route::get('/ideas/{idea}/delete','IdeasController@delete')->middleware('revalidate','gateauth');

//Like Ideas.
Route::get('/ideas/{idea}/like','IdeasController@like')->middleware('revalidate','gateauth');
//Dislike Ideas.
Route::get('/ideas/{idea}/dislike','IdeasController@dislike')->middleware('revalidate','gateauth');

//View individual comment of user ideas.
Route::get('/ideas/{idea}/comments','IdeasController@viewComments')->middleware('revalidate','gateauth');

//Add Comments.
Route::get('/ajax/comment/{comment}','CommentController@viewComment')->middleware('revalidate','gateauth');
Route::post('/ajax/comment/{idea}','CommentController@addComment')->middleware('revalidate','gateauth');


//Delete Comment
Route::get('comments/{comment}/delete','CommentController@deleteComment')->middleware('revalidate','gateauth');


//Project Add.
Route::get('/projects/create','ProjectsController@create')->middleware('revalidate','gateauth');
Route::post('/projects/create','ProjectsController@store')->middleware('revalidate','gateauth');

//List Individual Ideas Route
Route::get('/projects','ProjectsController@list')->middleware('revalidate','gateauth');

//Edit Project Route
Route::get('/projects/{project}/edit','ProjectsController@edit')->middleware('revalidate','gateauth');
Route::post('/projects/{project}/edit','ProjectsController@update')->middleware('revalidate','gateauth');

//Delete Project Functionality
Route::get('/projects/{project}/delete','ProjectsController@delete')->middleware('revalidate','gateauth');

//Users List
Route::get('/users','UserController@list')->middleware('revalidate','gateauth');


//Make Admim Ajax.
Route::get('/ajax/admin/{user}/{checked}','UserController@makeAdmin')->middleware('revalidate','gateauth');


//View Project specific ideas for the Project Admins.
Route::get('/projects/{project}/ideas','ProjectsController@ideas')->middleware('revalidate','gateauth');

//View individual idea in the project.
Route::get('/project/{project}/ideas/{idea}/comments','ProjectsController@viewIdea')->middleware('revalidate','gateauth');

//Change Status
Route::get('/project/{project}/ideas/{idea}/status','ProjectsController@status')->middleware('revalidate','gateauth');
Route::post('/project/{project}/ideas/{idea}/status','ProjectsController@addStatus')->middleware('revalidate','gateauth');

//status history for ideas on home page.
Route::get('/ideas/{idea}/statushistory','IdeasController@statushistory')->middleware('revalidate','gateauth');

//status history for ideas on project page.
Route::get('/project/{project}/ideas/{idea}/statushistory','ProjectsController@statushistory')->middleware('revalidate','gateauth');

//User Ideas
Route::get('/user/ideas','IdeasController@userideas')->middleware('revalidate','gateauth');

//User Drafts
Route::get('/user/ideas/drafts','DraftsController@view')->middleware('revalidate','gateauth');

//Edit Idea Route
Route::get('/drafts/{draft}/edit','DraftsController@edit')->middleware('revalidate','gateauth');
Route::post('/drafts/{draft}/edit','DraftsController@update')->middleware('revalidate','gateauth');

//Delete Idea Functionality
Route::get('/drafts/{draft}/delete','DraftsController@delete')->middleware('revalidate','gateauth');