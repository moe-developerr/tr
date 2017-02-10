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

Auth::routes();

Route::post('boards/{board}/addMember', 'BoardsController@addMember');
Route::get('boards/{board}/nonMembers', 'BoardsController@nonMembers');
Route::resource('boards', 'BoardsController');
Route::group(['middleware' => ['auth']], function () {
	Route::resource('lists', 'ListsController');
	Route::resource('cards', 'CardsController');
	Route::resource('comments', 'CommentsController');
});