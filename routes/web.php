<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');



Route::prefix('matches')->name('matches.')->group(function () {

    Route::get('/schedule', 'HomeController@schedule')->name('schedule');

    Route::get('/result', 'HomeController@result')->name('result');

    Route::get('/standing', 'HomeController@standing')->name('standing');

    Route::get('/player', 'HomeController@player')->name('player');

});

Route::get('/player/{id}', 'HomeController@getPlayerDetails')->name('player.details');
Route::get('/team/{teamId}/players', 'HomeController@teamPlayers');
Route::get('/get/team/{teamId}/players', 'TeamController@getTeamPlayers');

Route::get('/top-scorers', 'HomeController@topScorers')->name('top.scorers');

Route::get('/contact', 'HomeController@contact')->name('contact');


Route::get('/team-registration', 'RegistrationController@teamRegistrationLayout')->name('team.registration');
Route::post('/team-registration', 'RegistrationController@storeTeam')->name('team.store');

Route::get('/player-registration', 'RegistrationController@playerRegistrationLayout')->name('player.registration');
Route::post('/player-registration', 'RegistrationController@storePlayer')->name('player.store');

Route::get('/event', 'HomeController@event')->name('event');
Route::get('/event/{event_id}', 'HomeController@eventDetail');

Route::get('/transfer-request', 'PlayerTransferController@index')->name('transfer.request.form');
Route::post('/transfer-request', 'PlayerTransferController@store');


Route::get('/match/{id}', 'HomeController@matchDetails');



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

    Route::post('/add/team', 'TeamController@addTeam');
    Route::post('/edit/team', 'TeamController@editTeam');
    Route::post('/delete/team', 'TeamController@deleteTeam');

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

    Route::get('/manage/matches', 'MatchController@index')->name('admin.match');

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
    Route::get('/match/{matchId}/players', 'LiveScoreController@getMatchPlayers')->name('admin.match.finish');

    Route::post('/calculate-pts', 'LiveScoreController@calculatePTS');
    Route::post('/calculate-player-statistics', 'LiveScoreController@calculatePlayerStatistics');



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



    /*
    * Attendance & Contribution Routes
    */

    Route::get('/insert-contribution', 'ContributionController@index')->name('insert.contribution');
    Route::post('/contribution/insert', 'ContributionController@insertAttendanceContribution');

    Route::get('/view-contribution', 'ContributionController@viewContribution')->name('view.contribution.layout');
    Route::post('/view-contribution', 'ContributionController@generateContributionReport')->name('view.contribution');



    /*
    * Event Routes
    */

    Route::get('/events', 'EventController@index')->name('admin.event');

    Route::post('/add/event', 'EventController@addEvent');
    Route::post('/edit/event', 'EventController@editEvent');
    Route::post('/delete/event', 'EventController@deleteEvent');



    /*
    * Player Transfer Routes
    */

    Route::get('/transfer-requests', 'PlayerTransferController@transferRequest')->name('transfer.request');
    Route::post('/update/transfer-status', 'PlayerTransferController@updateTransferStatus');

    Route::get('/request-history', 'PlayerTransferController@requestHistory')->name('request.history');


});




