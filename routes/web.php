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
    Route::get('/team/{team}/players', 'TeamController@getTeamPlayers');



    /*
    * Player Routes
    */

    Route::get('/manage-players', 'PlayerController@index')->name('admin.player');
    Route::post('/manage-players', 'PlayerController@searchPlayer')->name('admin.search.player');

    Route::post('/add/player', 'PlayerController@addPlayer')->name('admin.add.player');
    Route::post('/edit/player', 'PlayerController@editPlayer')->name('admin.edit.player');
    Route::post('/delete/player', 'PlayerController@deletePlayer')->name('admin.delete.player');



    /*
    * League Routes
    */

    Route::get('/leagues', 'LeagueController@index')->name('admin.league');

    Route::post('/add/league', 'LeagueController@addLeague')->name('admin.add.league');
    Route::post('/edit/league', 'LeagueController@editLeague')->name('admin.edit.league');
    Route::post('/delete/league', 'LeagueController@deleteLeague')->name('admin.delete.league');



    /*
    * Match Routes
    */

    Route::get('/matches', 'MatchController@index')->name('admin.match');

    Route::post('/add/match', 'MatchController@addMatch')->name('admin.add.match');
    Route::post('/edit/match', 'MatchController@editMatch')->name('admin.edit.match');
    Route::post('/delete/match', 'MatchController@deleteMatch')->name('admin.delete.match');



    /*
    * Live Score Routes
    */

    Route::get('/live-matches', 'LiveScoreController@liveMatches')->name('admin.live.matches');
    Route::get('/finished-matches', 'LiveScoreController@finishedMatches')->name('admin.finished.matches');
    Route::get('/match/{match}/events', 'LiveScoreController@getMatchEvents')->name('admin.match.events');
    Route::post('/match/{match}/update-score', 'LiveScoreController@updateMatchScore')->name('admin.match.update.score');
    Route::post('/match/{match}/add-event', 'LiveScoreController@addMatchEvent')->name('admin.match.add.event');
    Route::post('/match/{match}/delete-event', 'LiveScoreController@deleteMatchEvent')->name('admin.match.delete.event');
    Route::post('/match/{match}/finish', 'LiveScoreController@finishMatch')->name('admin.match.finish');



    /*
    * User Routes
    */

    Route::get('/users', 'UserController@index')->name('admin.user');
    Route::post('/add/user', 'UserController@addUser');
    Route::post('/edit/user', 'UserController@editUser');
    Route::post('/delete/user', 'UserController@deleteUser');



    /*
    * Profile Routes
    */

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/edit/profile', 'ProfileController@editProfile')->name('profile.edit');
    Route::post('/edit/password', 'ProfileController@editPassword')->name('profile.edit.password');
    Route::post('/remove/profilePicture', 'ProfileController@removeProfilePicture');


});




