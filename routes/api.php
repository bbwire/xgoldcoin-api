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

    // Countries

    Route::get('/countries', 'CountryController@index');
    Route::post('/countries', 'CountryController@store');
    Route::get('/countries/{id}', 'CountryController@show');
    Route::post('/countries/{id}', 'CountryController@update');
    Route::delete('/countries/{id}', 'CountryController@destroy');

    // Cities

    Route::get('/cities', 'CityController@index');
    Route::post('/cities', 'CityController@store');
    Route::get('/cities/{id}', 'CityController@show');
    Route::post('/cities/{id}', 'CityController@update');
    Route::delete('/cities/{id}', 'CityController@destroy');

    // Packages

    Route::get('/packages', 'AccountPackageController@index');
    Route::post('/packages', 'AccountPackageController@store');
    Route::get('/packages/{id}', 'AccountPackageController@show');
    Route::post('/packages/{id}', 'AccountRPackageController@update');
    Route::delete('/packages/{id}', 'AccountPackageController@destroy');

    // Payments

    Route::get('/payments', 'PaymentController@index');
    Route::post('/payments', 'PaymentController@store');
    Route::get('/payments/{id}', 'PaymentController@show');
    Route::post('/payments/{id}', 'PaymentController@update');
    Route::delete('/payments/{id}', 'PaymentController@destroy');

    // Roles

    Route::get('/roles', 'RoleController@index');
    Route::post('/roles', 'RoleController@store');
    Route::get('/roles/{id}', 'RoleController@show');
    Route::post('/roles/{id}', 'RoleController@update');
    Route::delete('/roles/{id}', 'RoleController@destroy');

    // Settings

    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@store');
    Route::get('/settings/{id}', 'SettingController@show');
    Route::post('/settings/{id}', 'SettingController@update');
    Route::delete('/settings/{id}', 'SettingController@destroy');


    // Users

    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@store');
    Route::get('/users/{id}', 'UserController@show');
    Route::post('/users/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@destroy');
    Route::post('/user/login', 'UserController@login');
    Route::get('/user/verification/{token}', 'UserController@verification');
    Route::post('/users/password/recovery', 'UserController@password_recovery');

    Route::post('/identity/documents', 'IdentityDocumentController@store');

});
