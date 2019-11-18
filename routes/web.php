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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/notes', 'NotesController@index');
Route::get('/notes/create', 'NotesController@create');
Route::post('/notes', 'NotesController@store');
Route::get('/notes/{note}', 'NotesController@show');
Route::get('/notes/{note}/edit', 'NotesController@edit');
Route::put('/notes/{note}', 'NotesController@update');
Route::delete('/notes/{note}', 'NotesController@destroy');

/*
Verb 	URI 	Action 	Route Name
GET 	/photos 	index 	photos.index
GET 	/photos/create 	create 	photos.create
POST 	/photos 	store 	photos.store
GET 	/photos/{photo} 	show 	photos.show
GET 	/photos/{photo}/edit 	edit 	photos.edit
PUT/PATCH 	/photos/{photo} 	update 	photos.update
DELETE 	/photos/{photo} 	destroy 	photos.destroy

Auth::routes();