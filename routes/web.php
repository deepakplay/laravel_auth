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


Auth::routes();
Route::resource('/posts/post', 'PostsController', ['except'=>['create', 'show', 'index']])->middleware('auth');

Route::get('/', 'PostsController@index')->name('index');
Route::get('/posts', 'PostsController@posts')->name('posts');