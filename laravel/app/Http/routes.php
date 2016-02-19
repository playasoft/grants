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

// Routes available to all users
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

// Routes available to logged in users
Route::group(['middleware' => ['auth']], function()
{
    // Creating and viewing grant applications
    Route::get('/applications', 'ApplicationController@listApplications');
    Route::post('/applications', 'ApplicationController@createApplication');
    Route::get('/applications/create', 'ApplicationController@createApplicationForm');
    Route::get('/applications/{application}', 'ApplicationController@viewApplication');
    Route::post('/applications/{application}', 'ApplicationController@updateApplication');
    Route::get('/applications/{application}/review', 'ApplicationController@reviewApplication');
    Route::post('/applications/{application}/submit', 'ApplicationController@submitApplication');

    // Answering questions
    Route::post('/answers', 'AnswerController@createAnswer');
    Route::post('/answers/{answer}', 'AnswerController@updateAnswer');

    // Handling documents
    Route::get('/documents/{document}/delete', 'DocumentController@deleteDocument');
});

// Routes available to both admins and judges
Route::group(['middleware' => ['auth', 'role:admin|judge|observer']], function()
{
    // Viewing questions
    Route::get('/questions', 'QuestionController@listQuestions');

    // Viewing users
    Route::get('/users', 'UserController@listUsers');
    Route::get('/users/{user}', 'UserController@viewUser');
});

// Routes only available to admins
Route::group(['middleware' => ['auth', 'role:admin']], function()
{
    // Creating and modifying questions
    Route::post('/questions', 'QuestionController@createQuestion');
    Route::get('/questions/create', 'QuestionController@createQuestionForm');
    Route::get('/questions/{question}', 'QuestionController@editQuestionForm');
    Route::post('/questions/{question}', 'QuestionController@editQuestion');
    Route::get('/questions/{question}/delete', 'QuestionController@deleteQuestion');
});
