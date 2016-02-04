<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function()
{
    // Basic pages
    Route::get('/', 'PageController@home');
    Route::get('/about', 'PageController@view');

    // User authentication routes
    Route::get('/register', 'PageController@view');
    Route::get('/login', 'PageController@view');
    Route::get('/logout', 'UserController@logout');

    Route::post('/register', 'UserController@create');
    Route::post('/login', 'UserController@login');
});

Route::group(['middleware' => ['auth']], function()
{
    // Grant application routes
    Route::get('/applications', 'ApplicationController@listApplications');
    Route::post('/applications', 'ApplicationController@createApplication');
    Route::get('/applications/create', 'ApplicationController@createApplicationForm');
    Route::get('/applications/{application}', 'ApplicationController@viewApplication');
    Route::post('/applications/{application}', 'ApplicationController@updateApplication');
});

Route::group(['middleware' => ['admin']], function()
{
    // Question routes
    Route::get('/questions', 'QuestionController@listQuestions');
    Route::post('/questions', 'QuestionController@createQuestion');
    Route::get('/questions/create', 'QuestionController@createQuestionForm');
    Route::get('/questions/{question}', 'QuestionController@editQuestionForm');
    Route::post('/questions/{question}', 'QuestionController@editQuestion');

    // User administration routes
    Route::get('/users', 'UserController@listUsers');
    Route::get('/users/{user}', 'UserController@viewUser');
});
