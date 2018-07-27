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


Route::get('coffes/get', 'api\CoffeService@index') ->name('coffe.get');
Route::get('categorys/get', 'api\CategoryService@index') ->name('category.get');  


Route::middleware('auth:api')->group(function(){
    Route::resource('categorys','api\CategoryService');
});

Route::middleware('auth:api')->group(function(){
    Route::resource('coffes','api\CoffeService');
});

Route::middleware('auth:api')->post('rate', 'api\CoffeService@vote');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
