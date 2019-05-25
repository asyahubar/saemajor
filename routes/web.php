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

// So, each file types handling would have their own routes

// xdxf
Route::get('/xdxf', 'XdxfController@index')->name('xdxf-form');
Route::post('/xdxf', 'XdxfController@store')->name('xdxf-save');

// pbi

// tei

// dic
Route::get('/dic', 'DicController@index')->name('dic-form');
Route::post('/dic', 'DicController@store')->name('dic-save');
