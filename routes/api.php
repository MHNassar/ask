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
Route::get('/', function () {
    $categoryUsers = \App\Category::find(2)->users()->pluck('user_id');
    return $categoryUsers;

});


Route::post('/register', 'UserLoginController@register');
Route::post('/login', 'UserLoginController@login');
Route::post('/forget/pass', 'UserLoginController@forgetPass');

Route::get('/twittes', 'TwitteController@geTwittes');
Route::get('questions/{q?}', 'QuestionController@getAllQuestions');
Route::get('/consultants', 'ConsultantController@getConsultants');


Route::group(['middleware' => ['custom_auth']], function () {
    Route::get('/user/profile', 'UserLoginController@getUser');
    Route::post('/user/profile/edit', 'UserLoginController@editUser');
    Route::post('/question/create', 'QuestionController@createQuestion');
    Route::post('/question/edit/{question_id}', 'QuestionController@updateQuestion');
    Route::post('question/delete/{question_id}', 'QuestionController@deleteQuestion');
    Route::post('question/filter', 'QuestionController@filter');
    Route::post('category/{category_id}/questions', 'QuestionController@listCategory');
    Route::post('question/like/{question_id}', 'QuestionController@likeQuestion');
    Route::post('question/unlike/{question_id}', 'QuestionController@unLikeQuestion');
    Route::get('user/questions/like', 'QuestionController@getLikedQuestions');
    Route::get('user/questions', 'QuestionController@getUserQuestions');
    Route::post('question/{question_id}/answer', 'AnswerController@createAnswer');
    Route::post('answer/{answer_id}/edit', 'AnswerController@updateAnswer');
    Route::post('suggestion/send', 'UserLoginController@sendSug');

    Route::get('/consultants/question/list', 'ConsultantController@getConsultantQuestions');

    /*
     * Chat
     */

    Route::post('conv/request', 'ConvController@requestConv');
    Route::post('conv/accept', 'ConvController@acceptConv');
    Route::get('conv/all', 'ConvController@getConvList');

});

