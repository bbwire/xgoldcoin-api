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

    // Bitcoin transactions

    Route::get('/bitcoin/transactions', 'BitcoinTransactionController@index');
    Route::post('/bitcoin/transactions', 'BitcoinTransactionController@store');
    Route::get('/bitcoin/transactions/{id}', 'BitcoinTransactionController@show');
    Route::post('/bitcoin/transactions/{id}', 'BitcoinTransactionController@update');
    Route::delete('/bitcoin/transactions/{id}', 'BitcoinTransactionController@destroy');
    Route::get('/bitcoin/transactions/client/{id}', 'BitcoinTransactionController@transactions_by_client');

    // Bitcoin transactions

    Route::get('/xgold/transactions', 'XgoldTransactionController@index');
    Route::post('/xgold/transactions', 'XgoldTransactionController@store');
    Route::get('/xgold/transactions/{id}', 'XgoldTransactionController@show');
    Route::post('/xgold/transactions/{id}', 'XgoldTransactionController@update');
    Route::delete('/xgold/transactions/{id}', 'XgoldTransactionController@destroy');
    Route::get('/xgold/transactions/client/{id}', 'XgoldTransactionController@transactions_by_client');
    
});
