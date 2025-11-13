<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');

Route::get('/matches', 'HomeController@match')->name('match');

Route::get('/players', 'HomeController@player')->name('player');
Route::get('/player/{id}', 'HomeController@getPlayerDetails')->name('player.details');

Route::get('/blog', 'HomeController@blog')->name('blog');

Route::get('/contact', 'HomeController@contact')->name('contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
