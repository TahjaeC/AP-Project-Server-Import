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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Sean Gayle
Route::get('products/searchByName','ProductController@searchByName');//works
Route::get('products/display','ProductController@display');//works
Route::get('products/disp','ProductController@disp');//works
Route::put('products/update', 'ProductController@update');// works
Route::delete('products/destroy/{id}', 'ProductController@destroy');// works
Route::post('products/store', 'ProductController@store');// works

//Tahjae Campbell
Route::put('cart/confirm', 'CartController@confirm');//c-confirm
Route::post('cart/confirm', 'CartController@confirm');
Route::get('chart/index', 'CartController@index');
