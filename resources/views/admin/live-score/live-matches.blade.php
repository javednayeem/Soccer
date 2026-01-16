@extends('layouts.admin')
@section('title', 'Live Matches')

@section('content')

    <input type="hidden" id="live_matches_json" value='@json($liveMatches)'>

    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="card-box">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--@if($liveMatches->count() > 0)--}}
                            {{--@foreach($liveMatches as $match)--}}
                                {{--<div class="card mb-4 border-primary shadow">--}}
                                    {{--<div class="card-header bg-primary text-white py-3">--}}
                                        {{--<div class="row align-items-center">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<h5 class="card-title mb-1 text-white">--}}
                                                    {{--<i class="fas fa-futbol mr-2"></i>--}}
                                                    {{--{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}--}}
                                                {{--</h5>--}}
                                                {{--<div class="d-flex align-items-center">--}}
                                                    {{--<small class="text-white-75">{{ $match->league->name }}</small>--}}
                                                    {{--<span class="mx-2">•</span>--}}
                                                    {{--<small class="text-white-75">{{ $match->match_week }}</small>--}}
                                                    {{--<span class="mx-2">•</span>--}}
                                                    {{--<small class="text-white-75">{{ $match->venue ?? 'Venue TBD' }}</small>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6 text-right">--}}
                                                {{--<div class="d-flex align-items-center justify-content-end">--}}
                                                {{--<span class="badge badge-light mr-2">--}}
                                                    {{--<i class="far fa-calendar-alt mr-1"></i>--}}
                                                    {{--{{ formatDateTime($match->match_date) }}--}}
                                                {{--</span>--}}
                                                    {{--<span class="badge badge-success badge-pill px-3 py-1">--}}
                                                    {{--<i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE--}}
                                                {{--</span>--}}
                                                    {{--<button class="btn btn-light btn-sm ml-3" onclick="showPlayersModal({{ $match->id }})" title="View Playing Players">--}}
                                                        {{--<i class="fas fa-users"></i> View Players--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="card-body">--}}
                                        {{--<div class="row">--}}
                                            {{--<!-- Match Score & Teams -->--}}
                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="match-score-card text-center p-4 border rounded">--}}
                                                    {{--<!-- Home Team -->--}}
                                                    {{--<div class="team-info mb-3">--}}
                                                        {{--<div class="team-logo mb-2">--}}
                                                            {{--<img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"--}}
                                                                 {{--alt="{{ $match->homeTeam->name }}"--}}
                                                                 {{--class="img-fluid"--}}
                                                                 {{--style="max-height: 60px;"--}}
                                                                 {{--onerror="this.onerror=null; this.src='/site/images/teams/default_team.png';">--}}
                                                        {{--</div>--}}
                                                        {{--<h6 class="font-weight-bold mb-1">{{ $match->homeTeam->name }}</h6>--}}
                                                    {{--</div>--}}

                                                    {{--<!-- Score -->--}}
                                                    {{--<div class="score-display my-3">--}}
                                                        {{--<div class="score-box d-inline-block px-4 py-2 bg-light rounded">--}}
                                                            {{--<h1 class="display-4 font-weight-bold text-primary mb-0">--}}
                                                                {{--<span id="home_score_{{ $match->id }}">{{ $match->home_team_score ?? 0 }}</span>--}}
                                                                {{--<span class="mx-2">-</span>--}}
                                                                {{--<span id="away_score_{{ $match->id }}">{{ $match->away_team_score ?? 0 }}</span>--}}
                                                            {{--</h1>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="text-muted small mt-2">Current Score</div>--}}
                                                    {{--</div>--}}

                                                    {{--<!-- Away Team -->--}}
                                                    {{--<div class="team-info mt-3">--}}
                                                        {{--<div class="team-logo mb-2">--}}
                                                            {{--<img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"--}}
                                                                 {{--alt="{{ $match->awayTeam->name }}"--}}
                                                                 {{--class="img-fluid"--}}
                                                                 {{--style="max-height: 60px;"--}}
                                                                 {{--onerror="this.onerror=null; this.src='/site/images/teams/default_team.png';">--}}
                                                        {{--</div>--}}
                                                        {{--<h6 class="font-weight-bold mb-1">{{ $match->awayTeam->name }}</h6>--}}
                                                    {{--</div>--}}

                                                    {{--<!-- Match Actions -->--}}
                                                    {{--<div class="match-actions mt-4 pt-3 border-top">--}}
                                                        {{--<button class="btn btn-primary btn-block mb-2" onclick="updateScore({{ $match->id }})">--}}
                                                            {{--<i class="fas fa-edit mr-1"></i> Update Score--}}
                                                        {{--</button>--}}
                                                        {{--<button class="btn btn-success btn-block" onclick="finishMatch({{ $match->id }})">--}}
                                                            {{--<i class="fas fa-flag-checkered mr-1"></i> Finish Match--}}
                                                        {{--</button>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<!-- Match Events -->--}}
                                            {{--<div class="col-md-5">--}}
                                                {{--<div class="card border h-100">--}}
                                                    {{--<div class="card-header bg-light">--}}
                                                        {{--<h6 class="mb-0">--}}
                                                            {{--<i class="fas fa-history mr-1"></i> Match Events Timeline--}}
                                                        {{--</h6>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="card-body p-0">--}}
                                                        {{--<div id="events_list_{{ $match->id }}" class="events-list p-3" style="max-height: 350px; overflow-y: auto;">--}}
                                                            {{--@if($match->events->count() > 0)--}}
                                                                {{--@foreach($match->events->sortBy('minute') as $event)--}}
                                                                    {{--<div class="event-item mb-2 p-3 border-left-4--}}
                                                                    {{--@if($event->type == 'goal') border-left-success--}}
                                                                    {{--@elseif($event->type == 'yellow_card') border-left-warning--}}
                                                                    {{--@elseif($event->type == 'red_card') border-left-danger--}}
                                                                    {{--@else border-left-info @endif">--}}
                                                                        {{--<div class="d-flex justify-content-between align-items-start">--}}
                                                                            {{--<div>--}}
                                                                                {{--<div class="d-flex align-items-center mb-1">--}}
                                                                                {{--<span class="badge--}}
                                                                                    {{--@if($event->type == 'goal') badge-success--}}
                                                                                    {{--@elseif($event->type == 'yellow_card') badge-warning--}}
                                                                                    {{--@elseif($event->type == 'red_card') badge-danger--}}
                                                                                    {{--@else badge-info @endif mr-2">--}}
                                                                                    {{--{{ strtoupper(substr($event->type, 0, 1)) }}--}}
                                                                                {{--</span>--}}
                                                                                    {{--<strong class="mr-2">{{ $event->player->first_name }} {{ $event->player->last_name }}</strong>--}}
                                                                                    {{--<small class="text-muted">{{ $event->minute }}'</small>--}}
                                                                                {{--</div>--}}
                                                                                {{--@if($event->description)--}}
                                                                                    {{--<p class="mb-0 text-muted small">{{ $event->description }}</p>--}}
                                                                                {{--@endif--}}
                                                                                {{--<small class="text-muted">--}}
                                                                                    {{--<i class="fas fa-users mr-1"></i>--}}
                                                                                    {{--{{ $event->team->name ?? 'Team' }}--}}
                                                                                {{--</small>--}}
                                                                            {{--</div>--}}
                                                                            {{--<button class="btn btn-xs btn-outline-danger" onclick="deleteEvent({{ $match->id }}, {{ $event->id }})">--}}
                                                                                {{--<i class="fas fa-trash"></i>--}}
                                                                            {{--</button>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--@endforeach--}}
                                                            {{--@else--}}
                                                                {{--<div class="text-center py-4">--}}
                                                                    {{--<i class="fas fa-clock fa-2x text-muted mb-3"></i>--}}
                                                                    {{--<p class="text-muted mb-0">No events recorded yet</p>--}}
                                                                {{--</div>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="card-footer bg-light">--}}
                                                        {{--<button class="btn btn-outline-primary btn-sm" onclick="addEvent({{ $match->id }})">--}}
                                                            {{--<i class="fas fa-plus mr-1"></i> Add Event--}}
                                                        {{--</button>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<!-- Quick Actions & Players -->--}}
                                            {{--<div class="col-md-3">--}}
                                                {{--<div class="card border h-100">--}}
                                                    {{--<div class="card-header bg-light">--}}
                                                        {{--<h6 class="mb-0">--}}
                                                            {{--<i class="fas fa-bolt mr-1"></i> Quick Actions--}}
                                                        {{--</h6>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="card-body">--}}
                                                        {{--<div class="list-group list-group-flush">--}}
                                                            {{--<button class="list-group-item list-group-item-action d-flex align-items-center" onclick="quickGoal('{{ $match->id }}', '{{ $match->home_team_id }}')">--}}
                                                                {{--<i class="fas fa-futball mr-2 text-success"></i>--}}
                                                                {{--<span>Home Goal</span>--}}
                                                                {{--<span class="badge badge-success ml-auto">+1</span>--}}
                                                            {{--</button>--}}
                                                            {{--<button class="list-group-item list-group-item-action d-flex align-items-center" onclick="quickGoal('{{ $match->id }}', '{{ $match->away_team_id }}')">--}}
                                                                {{--<i class="fas fa-futball mr-2 text-success"></i>--}}
                                                                {{--<span>Away Goal</span>--}}
                                                                {{--<span class="badge badge-success ml-auto">+1</span>--}}
                                                            {{--</button>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--@else--}}
                            {{--<div class="text-center py-5">--}}
                                {{--<div class="empty-state-icon mb-3">--}}
                                    {{--<i class="fe-clock display-4 text-muted"></i>--}}
                                {{--</div>--}}
                                {{--<h4 class="text-muted mt-3">No Live Matches</h4>--}}
                                {{--<p class="text-muted mb-4">There are currently no live matches to manage.</p>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        @if($liveMatches->count() > 0)
                            @foreach($liveMatches as $match)
                                @php
                                    // Get players for both teams (you need to add this to your controller)
                                    $homeTeamPlayers = \App\Models\Player::where('team_id', $match->home_team_id)
                                        ->where('player_status', '1')
                                        ->where('payment_status', '1')
                                        ->orderBy('position')
                                        ->orderBy('jersey_number')
                                        ->get();

                                    $awayTeamPlayers = \App\Models\Player::where('team_id', $match->away_team_id)
                                        ->where('player_status', '1')
                                        ->where('payment_status', '1')
                                        ->orderBy('position')
                                        ->orderBy('jersey_number')
                                        ->get();
                                @endphp

                                <div class="card mb-4 border-primary shadow">
                                    <div class="card-header bg-primary text-white py-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h5 class="card-title mb-1 text-white">
                                                    <i class="fas fa-futbol mr-2"></i>
                                                    {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <small class="text-white-75">{{ $match->league->name }}</small>
                                                    <span class="mx-2">•</span>
                                                    <small class="text-white-75">{{ $match->match_week }}</small>
                                                    <span class="mx-2">•</span>
                                                    <small class="text-white-75">{{ $match->venue ?? 'Venue TBD' }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="d-flex align-items-center justify-content-end">
                                                <span class="badge badge-light mr-2">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ formatDateTime($match->match_date) }}
                                                </span>
                                                    <span class="badge badge-success badge-pill px-3 py-1">
                                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE
                                                </span>
                                                    <span class="badge badge-info ml-3">
                                                    <i class="fas fa-users mr-1"></i>
                                                        {{ $homeTeamPlayers->count() + $awayTeamPlayers->count() }} Players
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Match Score & Teams -->
                                            <div class="col-lg-3 col-md-12 mb-md-3">
                                                <div class="match-score-card text-center p-4 border rounded h-100">

                                                    <div class="team-info mb-3">
                                                        <div class="team-logo mb-2">
                                                            <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}" alt="{{ $match->homeTeam->name }}" class="img-fluid" style="max-height: 60px;" onerror="this.onerror=null; this.src='/site/images/teams/default_team.png';">
                                                        </div>
                                                        <h6 class="font-weight-bold mb-1">{{ $match->homeTeam->name }}</h6>
                                                        <span class="badge badge-primary">{{ $homeTeamPlayers->count() }} Players</span>
                                                    </div>

                                                    <div class="score-display my-3">
                                                        <div class="score-box d-inline-block px-4 py-2 bg-light rounded">
                                                            <h1 class="display-4 font-weight-bold text-primary mb-0">
                                                                <span id="home_score_{{ $match->id }}">{{ $match->home_team_score ?? 0 }}</span>
                                                                <span class="mx-2">-</span>
                                                                <span id="away_score_{{ $match->id }}">{{ $match->away_team_score ?? 0 }}</span>
                                                            </h1>
                                                        </div>
                                                        <div class="text-muted small mt-2">Current Score</div>
                                                    </div>

                                                    <div class="team-info mt-3">
                                                        <div class="team-logo mb-2">
                                                            <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}" alt="{{ $match->awayTeam->name }}" class="img-fluid" style="max-height: 60px;" onerror="this.onerror=null; this.src='/site/images/teams/default_team.png';">
                                                        </div>
                                                        <h6 class="font-weight-bold mb-1">{{ $match->awayTeam->name }}</h6>
                                                        <span class="badge badge-danger">{{ $awayTeamPlayers->count() }} Players</span>
                                                    </div>

                                                    <div class="match-actions mt-4 pt-3 border-top">
                                                        <button class="btn btn-primary btn-block mb-2" onclick="updateScore({{ $match->id }})">
                                                            <i class="fas fa-edit mr-1"></i> Update Score
                                                        </button>
                                                        <button class="btn btn-success btn-block" onclick="finishMatch({{ $match->id }})">
                                                            <i class="fas fa-flag-checkered mr-1"></i> Finish Match
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12">
                                                <div class="row">
                                                    <!-- Home Team Players -->
                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                        <div class="card border h-100">
                                                            <div class="card-header bg-primary text-white">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-users mr-1"></i>
                                                                        {{ $match->homeTeam->name }} - Players
                                                                    </h6>
                                                                    <span class="badge badge-light">{{ $homeTeamPlayers->count() }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <div class="players-list" style="max-height: 300px; overflow-y: auto;">
                                                                    @if($homeTeamPlayers->count() > 0)
                                                                        <table class="table table-sm table-hover mb-0">
                                                                            <thead class="thead-light">
                                                                            <tr>
                                                                                <th class="py-2" style="width: 40px;">#</th>
                                                                                <th class="py-2">Player</th>
                                                                                <th class="py-2" style="width: 80px;">Position</th>
                                                                                <th class="py-2" style="width: 80px;">Actions</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($homeTeamPlayers as $player)
                                                                                <tr>
                                                                                    <td class="align-middle">
                                                                                        @if($player->jersey_number)
                                                                                            <span class="badge badge-primary">#{{ $player->jersey_number }}</span>
                                                                                        @else
                                                                                            <span class="text-muted">-</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="mr-2">
                                                                                                <img src="{{ asset($player->photo) }}" alt="{{ $player->first_name }}" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;" onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg';">
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="font-weight-bold" style="font-size: 0.9rem;">
                                                                                                    {{ $player->first_name }} {{ $player->last_name }}
                                                                                                </div>
                                                                                                <div class="text-muted small">
                                                                                                    {{ $player->nationality }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <span class="badge badge-secondary">{{ $player->position }}</span>
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <div class="btn-group btn-group-sm">
                                                                                            <button class="btn btn-outline-success btn-sm" onclick="quickGoal({{ $match->id }}, {{ $match->home_team_id }}, {{ $player->id }})" title="Goal">
                                                                                                <i class="fas fa-futbol"></i>
                                                                                            </button>
                                                                                            <button class="btn btn-outline-warning btn-sm" onclick="addCard({{ $match->id }}, {{ $match->home_team_id }}, {{ $player->id }}, 'yellow_card')" title="Yellow Card">
                                                                                                <i class="fas fa-square"></i>
                                                                                            </button>
                                                                                            <button class="btn btn-outline-danger btn-sm" onclick="addCard({{ $match->id }}, {{ $match->home_team_id }}, {{ $player->id }}, 'red_card')" title="Red Card">
                                                                                                <i class="fas fa-square"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @else
                                                                        <div class="text-center py-4">
                                                                            <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                                                            <p class="text-muted mb-0">No active players</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-light py-2">
                                                                <small class="text-muted">
                                                                    Click on action buttons to quickly add goals/cards
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card border h-100">
                                                            <div class="card-header bg-danger text-white">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-users mr-1"></i>
                                                                        {{ $match->awayTeam->name }} - Players
                                                                    </h6>
                                                                    <span class="badge badge-light">{{ $awayTeamPlayers->count() }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <div class="players-list" style="max-height: 300px; overflow-y: auto;">
                                                                    @if($awayTeamPlayers->count() > 0)
                                                                        <table class="table table-sm table-hover mb-0">
                                                                            <thead class="thead-light">
                                                                            <tr>
                                                                                <th class="py-2" style="width: 40px;">#</th>
                                                                                <th class="py-2">Player</th>
                                                                                <th class="py-2" style="width: 80px;">Position</th>
                                                                                <th class="py-2" style="width: 80px;">Actions</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($awayTeamPlayers as $player)
                                                                                <tr>
                                                                                    <td class="align-middle">
                                                                                        @if($player->jersey_number)
                                                                                            <span class="badge badge-danger">#{{ $player->jersey_number }}</span>
                                                                                        @else
                                                                                            <span class="text-muted">-</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="mr-2">
                                                                                                <img src="{{ asset($player->photo) }}"
                                                                                                     alt="{{ $player->first_name }}"
                                                                                                     class="rounded-circle"
                                                                                                     style="width: 30px; height: 30px; object-fit: cover;"
                                                                                                     onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg';">
                                                                                            </div>
                                                                                            <div>
                                                                                                <div class="font-weight-bold" style="font-size: 0.9rem;">
                                                                                                    {{ $player->first_name }} {{ $player->last_name }}
                                                                                                </div>
                                                                                                <div class="text-muted small">
                                                                                                    {{ $player->nationality }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <span class="badge badge-secondary">{{ $player->position }}</span>
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        <div class="btn-group btn-group-sm">
                                                                                            <button class="btn btn-outline-success btn-sm" onclick="quickGoal({{ $match->id }}, {{ $match->away_team_id }}, {{ $player->id }})" title="Goal">
                                                                                                <i class="fas fa-futbol"></i>
                                                                                            </button>
                                                                                            <button class="btn btn-outline-warning btn-sm" onclick="addCard({{ $match->id }}, {{ $match->away_team_id }}, {{ $player->id }}, 'yellow_card')" title="Yellow Card">
                                                                                                <i class="fas fa-square"></i>
                                                                                            </button>
                                                                                            <button class="btn btn-outline-danger btn-sm" onclick="addCard({{ $match->id }}, {{ $match->away_team_id }}, {{ $player->id }}, 'red_card')" title="Red Card">
                                                                                                <i class="fas fa-square"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @else
                                                                        <div class="text-center py-4">
                                                                            <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                                                            <p class="text-muted mb-0">No active players</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-light py-2">
                                                                <small class="text-muted">
                                                                    Click on action buttons to quickly add goals/cards
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Match Events -->
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="card border">
                                                            <div class="card-header bg-light">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-history mr-1"></i> Match Events Timeline
                                                                    </h6>
                                                                    <button class="btn btn-outline-primary btn-sm" onclick="addEvent({{ $match->id }})">
                                                                        <i class="fas fa-plus mr-1"></i> Add Event
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <div id="events_list_{{ $match->id }}" class="events-list p-3" style="max-height: 200px; overflow-y: auto;">
                                                                    @if($match->events->count() > 0)
                                                                        @foreach($match->events->sortBy('minute') as $event)
                                                                            <div class="event-item mb-2 p-2 border rounded">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <div class="d-flex align-items-center">
                                                                                        <span class="badge mr-2
                                                                                            @if($event->type == 'goal') badge-success
                                                                                            @elseif($event->type == 'yellow_card') badge-warning
                                                                                            @elseif($event->type == 'red_card') badge-danger
                                                                                            @else badge-info @endif">
                                                                                            {{ strtoupper(substr($event->type, 0, 1)) }}
                                                                                        </span>
                                                                                            <strong>{{ $event->player->first_name }} {{ $event->player->last_name }}</strong>
                                                                                            <small class="text-muted mx-2">({{ $event->minute }}')</small>
                                                                                            <span class="badge badge-light">
                                                                                            {{ $event->team->name ?? 'Team' }}
                                                                                        </span>
                                                                                        </div>
                                                                                        @if($event->description)
                                                                                            <small class="text-muted d-block mt-1">{{ $event->description }}</small>
                                                                                        @endif
                                                                                    </div>
                                                                                    <button class="btn btn-xs btn-outline-danger" onclick="deleteEvent({{ $match->id }}, {{ $event->id }})">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="text-center py-3">
                                                                            <i class="fas fa-clock fa-lg text-muted mb-2"></i>
                                                                            <p class="text-muted mb-0">No events recorded yet</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mb-3">
                                    <i class="fe-clock display-4 text-muted"></i>
                                </div>
                                <h4 class="text-muted mt-3">No Live Matches</h4>
                                <p class="text-muted mb-4">There are currently no live matches to manage.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updateScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Match Score</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="score_match_id">

                    <!-- Loading State -->
                    <div id="score_loading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading match details...</p>
                    </div>

                    <!-- Content -->
                    <div id="score_content" style="display: none;">
                        <!-- Score Section -->
                        <div class="score-section mb-4">
                            <h6 class="text-center mb-3 text-muted">Final Score</h6>
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <label id="home_team_name" class="font-weight-bold d-block text-center mb-2"></label>
                                        <input type="number" class="form-control text-center font-weight-bold"
                                               id="home_score" min="0" value="0" style="font-size: 1.2rem;">
                                    </div>
                                    <div class="col-2 text-center">
                                        <span class="h4 text-muted">-</span>
                                    </div>
                                    <div class="col-5">
                                        <label id="away_team_name" class="font-weight-bold d-block text-center mb-2"></label>
                                        <input type="number" class="form-control text-center font-weight-bold"
                                               id="away_score" min="0" value="0" style="font-size: 1.2rem;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Man of the Match Section -->
                        <div id="motm_section" class="motm-section border-top pt-3">
                            <h6 class="text-center mb-3 text-muted">
                                <i class="mdi mdi-trophy-outline text-warning mr-2"></i>
                                Man of the Match
                            </h6>
                            <div class="form-group">
                                <select class="form-control" id="man_of_the_match">
                                    <option value="">Select Man of the Match</option>
                                    <!-- Players will be loaded via AJAX -->
                                </select>
                                <small class="form-text text-muted">
                                    Select the outstanding player from either team (optional)
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveScore()">
                        <i class="mdi mdi-content-save mr-1"></i>
                        Update Score
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="addEventModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Match Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_match_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Team</label>
                                <select class="form-control" id="event_team_id">
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Player</label>
                                <select class="form-control" id="event_player_id">
                                    <option value="">Select Player</option>
                                    <!-- Players will be loaded via AJAX -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Type</label>
                                <select class="form-control" id="event_type">
                                    <option value="goal">Goal</option>
                                    <option value="assist">Assist</option>
                                    <option value="yellow_card">Yellow Card</option>
                                    <option value="red_card">Red Card</option>
                                    <option value="substitution_in">Substitution In</option>
                                    <option value="substitution_out">Substitution Out</option>
                                    <option value="man_of_the_match">Man Of The Match</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minute</label>
                                <input type="number" class="form-control" id="event_minute" min="1" max="120" placeholder="Minute">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description (Optional)</label>
                                <textarea class="form-control" id="event_description" placeholder="Event description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEvent()">Add Event</button>
                </div>
            </div>
        </div>
    </div>

@endsection