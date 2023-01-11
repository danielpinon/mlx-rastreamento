<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace'=>'Api'],function () {
    Route::post('login', 'AuthController@signin');
    Route::post('register', 'AuthController@signup');
    Route::group(['middleware' => 'auth:sanctum'],function () {
        Route::get('me', 'AuthController@me');
        Route::group(['prefix' => 'lotedetrabalho'],function () {
            Route::get('list', 'loteDeTrabalhoController@list');
            Route::get('{token}/info', 'loteDeTrabalhoController@info');
            Route::get('setores/list', 'loteDeTrabalhoController@setoresList');
            Route::post('update', 'loteDeTrabalhoController@updateItem');
        });
    });
});
