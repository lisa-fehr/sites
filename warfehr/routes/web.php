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
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    Route::get('/projects', function () {
        return view('projects');
    })->name('projects');
    Route::get('/projects/msg', 'MsgController@show')->name('msg');
});