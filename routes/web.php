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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('threads','ThreadController@index')->name('all_threads');
Route::get('threads/create','ThreadController@create')->name('add_thread');
Route::get('threads/{channel}/{thread}','ThreadController@show');
Route::post('threads','ThreadController@store')->name('store_thread');
Route::get('threads/{channel}','ThreadController@index')->name('all_channel');
Route::post('threads/{channel}/{thread}/replies','ReplyController@store')->name('add_reply');
