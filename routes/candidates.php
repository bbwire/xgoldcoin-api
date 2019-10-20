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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    // Candidates

    Route::get('/candidates', 'CandidateController@index');
    Route::post('/candidates', 'CandidateController@store');
    Route::get('/candidates/{id}', 'CandidateController@show');
    Route::post('/candidates/{id}', 'CandidateController@update');
    Route::delete('/candidates/{id}', 'CandidateController@destroy');
    Route::post('/candidate/login', 'CandidateController@login');
    Route::get('/candidate/account/verification/{token}', 'CandidateController@verification');
    Route::post('/candidates/password/recovery', 'CandidateController@password_recovery');

    // Education details

    Route::get('/education/details/candidate/{id}', 'EducationDetailController@candidate_education');
    Route::post('/education/details', 'EducationDetailController@store');
    Route::post('/education/details/{id}', 'EducationDetailController@update');
    Route::delete('/education/details/{id}', 'EducationDetailController@destroy');

    // Employment details

    Route::get('/employment/details/candidate/{id}', 'EmploymentRecordController@candidate_employment');
    Route::post('/employment/details', 'EmploymentRecordController@store');
    Route::post('/employment/details/{id}', 'EmploymentRecordController@update');
    Route::delete('/employment/details/{id}', 'EmploymentRecordController@destroy');

    // Profession details

    Route::get('/profession/details/candidate/{id}', 'ProfessionDetailController@candidate_profession');
    Route::post('/profession/details', 'ProfessionDetailController@store');
    Route::post('/profession/details/{id}', 'ProfessionDetailController@update');

});
