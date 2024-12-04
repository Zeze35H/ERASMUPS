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
// Home
Route::get('/', 'HomePageController@home');

Route::get('404', 'ErrorController@show404Page');
Route::get('403', 'ErrorController@show403Page');

Route::get('aboutUs', 'HomePageController@showAboutUsPage');

Route::get('questions', 'HomePageController@showQuestionsPage')->name('questions');

Route::get('questions/ask', 'QuestionController@showAddQuestionPage');
Route::post('questions/ask', 'QuestionController@addQuestion')->name('addQuestion');

Route::get('question/{id}', 'QuestionController@showQuestionPage');
Route::get('question/{id}/{title}', 'QuestionController@showQuestionPage');
Route::post('question/{id}/edit', 'QuestionController@editQuestion')->name('editQuestion');

Route::put('question/{id}/answer', 'AnswerController@addAnswer')->name('addAnswer');
Route::post('question/answer/{id_answer}/edit', 'AnswerController@editAnswer')->name('editAnswer');

Route::post('question/answer/{id_answer}/comment', 'CommentController@addComment')->name('addComment');
Route::post('question/answer/comment/{id_comment}/edit', 'CommentController@editComment')->name('editComment');

Route::put('question/{id}', 'QuestionController@close');

// votes //
Route::put('question/{id}/vote', 'QuestionController@voteQuestions');
Route::delete('question/{id}/vote', 'QuestionController@removeQuestionsVote');

Route::put('question/answer/{id_answer}/vote', 'AnswerController@voteAnswers');
Route::delete('question/answer/{id_answer}/vote', 'AnswerController@removeAnswersVote');

Route::put('question/answer/comment/{id_comment}/vote', 'CommentController@voteComments');
Route::delete('question/answer/comment/{id_comment}/vote', 'CommentController@removeCommentsVote');
// votes //

Route::put('user/{user_id}/follow', 'ProfileController@followedTags');
Route::delete('user/{user_id}/follow', 'ProfileController@unFollowedTags');

Route::delete('question/{id}', 'QuestionController@removeQuestion')->name('removeQuestion');
Route::delete('question/answer/{id_answer}', 'AnswerController@removeAnswer')->name('removeAnswer');
Route::delete('question/answer/comment/{id_comment}', 'CommentController@removeComment')->name('removeComment');

Route::post('question/report_content/{id_content}', 'ReportController@reportContent')->name('reportContent');

Route::put('/question/answer/{id_answer}/favAnswer', 'AnswerController@selectFavAnswer');
Route::delete('/question/answer/{id_answer}/favAnswer', 'AnswerController@removeFavAnswer');

Route::get('user/{id}', 'ProfileController@showProfilePage');
Route::delete('user/{id}', 'EditProfileController@deleteMyAccount')->name('deleteMyAccount');
Route::post('user/{id}', 'EditProfileController@applyForMod')->name('applyForMod');


Route::get('user/{id}/edit', 'EditProfileController@showEditProfilePage');
Route::post('user/{id}/edit', 'EditProfileController@editMyProfileInfo')->name('editMyProfileInfo');
Route::post('user/{id}/reset_picture', 'EditProfileController@resetPicture')->name('resetPicture');

Route::get('modappeals', 'ModController@showModAppeals');
Route::post('modappeals/treat_appeal/{id}', 'ModController@treatAppeal')->name('treatAppeal');
Route::post('modappeals/search', 'ModController@searchAppeals')->name('searchAppeals');

Route::get('modsdashboard', 'ModController@showModsDashboard');
Route::post('modsdashboard/treat_mod/{id}', 'ModController@treatMod')->name('treatMod');
Route::post('modsdashboard/search', 'ModController@searchModsOrUsers')->name('searchModsOrUsers');

Route::get('reports', 'ModController@showReports');
Route::delete('reports/treat_report/{id}', 'ModController@treatReport')->name('treatReport');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('login/reset', 'Auth\RecoveryController@showRecoveryForm')->middleware('guest')->name('recovery');
Route::post('login/reset', 'Auth\RecoveryController@sendRecoverEmail')->middleware('guest')->name('recoveryEmail');
Route::get('login/reset/submit', 'Auth\RecoveryController@showResetPassword')->middleware('guest')->name('resetPassword');
Route::post('login/reset/submit', 'Auth\RecoveryController@sendResetForm')->middleware('guest')->name('passwordUpdate');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
