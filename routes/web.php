<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');

Route::get('/matches', 'HomeController@match')->name('match');

Route::get('/players', 'HomeController@player')->name('player');
Route::get('/player/{id}', 'HomeController@getPlayerDetails')->name('player.details');

Route::get('/blog', 'HomeController@blog')->name('blog');

Route::get('/contact', 'HomeController@contact')->name('contact');


Route::get('/team-registration', 'RegistrationController@teamRegistrationLayout')->name('team.registration');
Route::post('/team-registration', 'RegistrationController@storeTeam')->name('team.store');

Route::get('/player-registration', 'RegistrationController@playerRegistrationLayout')->name('player.registration');
Route::post('/player-registration', 'RegistrationController@storePlayer')->name('player.store');


Auth::routes();



Route::group(['middleware'=> ['auth']],function ()  {

    /*
    * Dashboard Routes
    */

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');



    /*
    * Team Routes
    */

    Route::get('/teams', 'TeamController@index')->name('admin.team');

    Route::post('/change/team-status', 'TeamController@changeTeamStatus');
    Route::post('/update/team-active-status', 'TeamController@updateTeamActiveStatus');


    /*
    * Player Routes
    */

    Route::get('/manage-players', 'PlayerController@index')->name('admin.player');

    Route::post('/add/player', 'PlayerController@addPlayer')->name('admin.add.player');
    Route::post('/edit/player', 'PlayerController@editPlayer')->name('admin.edit.player');
    Route::post('/delete/player', 'PlayerController@deletePlayer')->name('admin.delete.player');


});




