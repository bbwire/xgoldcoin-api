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

    // Clients

    Route::get('/members', 'MemberController@index');
    Route::post('/members', 'MemberController@store');
    Route::get('/members/{id}', 'MemberController@show');
    Route::post('/members/{id}', 'MemberController@update');
    Route::delete('/members/{id}', 'MemberController@destroy');
    Route::post('/member/login', 'MemberController@login');
    Route::get('/members/account/verification/{token}', 'MemberController@verification');
    Route::post('/members/password/recovery', 'MemberController@password_recovery');
    Route::get('/members/user/{username}', 'MemberController@member_by_username');

    // Clients

    Route::get('/client/contacts', 'CompanyContactController@index');
    Route::get('/client/contacts/company/{id}', 'CompanyContactController@contacts_by_company');
    Route::post('/client/contacts/{id}', 'CompanyContactController@update');

});
