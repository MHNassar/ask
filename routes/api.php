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

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['custom_auth']], function () {
    Route::get('/user/profile', 'UserController@getUser');
    Route::post('/question/create', 'QuestionController@createQuestion');
    Route::post('/question/edit/{question_id}', 'QuestionController@updateQuestion');
    Route::post('question/delete/{question_id}', 'QuestionController@deleteQuestion');
    Route::post('category/{category_id}/questions', 'QuestionController@listCategory');
});

