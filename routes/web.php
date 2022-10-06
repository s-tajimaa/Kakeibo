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

Route::get('/', function () {
    return view('welcome');
});
 Route::get('kakeibo', 'KakeiboController@index');
 Route::post('kakeibo','KakeiboController@create');
 Route::get('kakeibo/delete','KakeiboController@delete');
 Route::post('kakeibo/bank','KakeiboController@bankaddition');
 Route::post('kakeibo/category','KakeiboController@categoryaddition');
