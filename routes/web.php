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

Route::get('/', 'PagesController@home');
Route::get('/result', 'PagesController@result')->name('result');
Route::get('/test', 'PagesController@test')->name('test');

// xdxf
Route::get('/xdxf', 'XdxfController@index')->name('xdxf-form');
Route::post('/xdxf', 'XdxfController@store')->name('xdxf-save');

// dsl
Route::get('/dsl', 'DslController@index')->name('dsl-form');
Route::post('/dsl', 'DslController@store')->name('dsl-save');

