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

Route::post('user/register', 'api\RegisterController@register');

Route::middleware('auth:api')->group(function(){
    Route::resource('categorys','api\CategoryService');
});

Route::middleware('auth:api')->group(function(){
    Route::resource('coffes','api\CoffeService');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
