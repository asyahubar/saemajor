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

Route::get('/', 'Controller@home');

// So, each file types handling would have their own routes

// xdxf
Route::get('/xdxf', 'XdxfController@index')->name('xdxf-form');
Route::post('/xdxf', 'XdxfController@create')->name('xdxf-save');

// pbi

// tei

// dic
