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
Route::get('/home', 'HomeController@index')->name('project.index');

Auth::routes();
Route::any('/project', 'HomeController@index')->name('project.index');
Route::any('/project/list', 'HomeController@list')->name('project.list');
Route::get('/project/create','HomeController@create')->name('project.create');
Route::post('/project/create','HomeController@store')->name('project.store');
Route::get('/project/{id}/edit','HomeController@edit')->name('project.edit');
Route::patch('/project/{id}/edit','HomeController@update')->name('project.update');
Route::delete('/project/{id}','HomeController@destroy')->name('project.destroy');

