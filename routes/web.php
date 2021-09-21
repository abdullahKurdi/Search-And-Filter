<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('project.index');



Auth::routes();
Route::any('/home', 'HomeController@index')->name('project.index');
Route::any('/home/list', 'HomeController@list')->name('project.list');
Route::get('/home/create','HomeController@create')->name('project.create');
Route::post('/home/create','HomeController@store')->name('project.store');
Route::get('/home/{id}/edit','HomeController@edit')->name('project.edit');
Route::patch('/home/{id}/edit','HomeController@update')->name('project.update');
Route::delete('/home/{id}','HomeController@destroy')->name('project.destroy');

