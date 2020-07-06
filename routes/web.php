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

Route::get('/', function () {
    return view('welcome');
});
Route::delete('/destroy/{id}', 'TaskController@destroy')->name('task.destroy');
Route::post('tasks/update','TaskController@update');
Route::resource('tasks', 'TaskController')->except(['update', 'delete', 'destroy']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
