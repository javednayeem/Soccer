@extends('layouts.site')
@section('title', 'Match Details - ' . ($match->homeTeam->name ?? 'Home') . ' vs ' . ($match->awayTeam->name ?? 'Away'))
@section('subtitle', 'Complete match information including players, events, and statistics')

@section('content')

    <div class="site-section bg-light">
        <div class="container">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('matches.schedule') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Schedule
                </a>
            </div>

            <!-- Match Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Match Header -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                            <span class="badge
                                @if($match->status === 'live') badge-danger
                                @elseif($match->status === 'finished') badge-success
                                @else badge-info @endif
                                mr-3 px-3 py-2">
                                @if($match->status === 'live')
                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> LIVE
                                @elseif($match->status === 'finished')
                                    <i class="fas fa-flag-checkered mr-1"></i> FINISHED
                                @else
                                    <i class="fas fa-calendar-alt mr-1"></i> UPCOMING
                                @endif
                            </span>
                                <div>
                                    <h4 class="mb-1 text-dark">{{ $match->league->name ?? 'League Match' }}</h4>
                                    <p class="text-muted mb-0">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $match->match_date->format('l, F j, Y') }}
                                        <i class="far fa-clock ml-2 mr-1"></i>
                                        {{ $match->match_date->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right">
                            @if($match->match_week)
                                <span class="badge badge-warning px-3 py-2">
                                <i class="fas fa-hashtag mr-1"></i> Match Week {{ $match->match_week }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Venue -->
                    <div class="text-center mb-4">
                        <p class="text-muted mb-0">
                            <i class="fas fa-map-marker-alt mr-2 text-danger"></i>
                            {{ $match->venue ?? 'Venue to be announced' }}
                        </p>
                    </div>

                    <!-- Teams and Score -->
                    <div class="row align-items-center">
                        <!-- Home Team -->
                        <div class="col-md-5 text-center">
                            <div class="mb-3">
                                <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                     alt="{{ $match->homeTeam->name }}"
                                     class="img-fluid rounded-circle border"
                                     style="width: 100px; height: 100px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                            </div>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $match->homeTeam->name }}</h3>
                            @if($match->homeTeam->short_name)
                                <p class="text-muted">({{ $match->homeTeam->short_name }})</p>
                            @endif
                            @if($result === 'home_win')
                                <span class="badge badge-success mt-2 px-3 py-1">
                                <i class="fas fa-trophy mr-1"></i> WINNER
                            </span>
                            @endif
                        </div>

                        <!-- Score Section -->
                        <div class="col-md-2 text-center">
                            @if($match->status === 'finished' || $match->status === 'live')
                                <div class="score-display">
                                    <h1 class="display-3 font-weight-bold text-primary mb-0">
                                        {{ $match->home_team_score ?? 0 }}
                                    </h1>
                                    <span class="mx-2" style="font-size: 2.5rem;">-</span>
                                    <h1 class="display-3 font-weight-bold text-primary mb-0">
                                        {{ $match->away_team_score ?? 0 }}
                                    </h1>
                                </div>
                                @if($isDraw)
                                    <span class="badge badge-secondary mt-2">DRAW</span>
                                @endif
                            @else
                                <div class="vs-section">
                                <span class="badge badge-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                      style="width: 70px; height: 70px; font-size: 1.2rem;">
                                    VS
                                </span>
                                </div>
                            @endif
                        </div>

                        <!-- Away Team -->
                        <div class="col-md-5 text-center">
                            <div class="mb-3">
                                <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                     alt="{{ $match->awayTeam->name }}"
                                     class="img-fluid rounded-circle border"
                                     style="width: 100px; height: 100px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                            </div>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $match->awayTeam->name }}</h3>
                            @if($match->awayTeam->short_name)
                                <p class="text-muted">({{ $match->awayTeam->short_name }})</p>
                            @endif
                            @if($result === 'away_win')
                                <span class="badge badge-success mt-2 px-3 py-1">
                                <i class="fas fa-trophy mr-1"></i> WINNER
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Man of the Match Section -->
            @if($match->mom_player_id)
                <div class="card border-0 shadow-sm mb-4 border-warning">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="mom-badge">
                                    <i class="fas fa-star fa-3x text-warning"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h4 class="text-warning mb-2">
                                    <i class="fas fa-crown mr-2"></i> Man of the Match
                                </h4>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <img src="{{ asset($match->momPlayer->photo) }}"
                                             alt="{{ $match->momPlayer->first_name }}"
                                             class="rounded-circle border"
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg';">
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-dark">{{ $match->momPlayer->first_name }} {{ $match->momPlayer->last_name }}</h5>
                                        <p class="text-muted mb-1">
                                            <span class="badge badge-info mr-2">{{ $match->momPlayer->position }}</span>
                                            <span class="badge badge-secondary">#{{ $match->momPlayer->jersey_number ?? 'N/A' }}</span>
                                        </p>
                                        <p class="mb-0 text-muted">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $match->momPlayer->team->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        <!-- Players Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-users mr-2"></i> Team Lineups
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Home Team Players -->
                        <div class="col-md-6">
                            <div class="team-players-section mb-4 mb-md-0">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary mb-0">
                                        <i class="fas fa-home mr-1"></i>
                                        {{ $match->homeTeam->name }}
                                    </h5>
                                    <span class="badge badge-primary">{{ $homeTeamPlayers->count() }} Players</span>
                                </div>

                                @if($homeTeamPlayers->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th class="py-2" style="width: 50px;">#</th>
                                                <th class="py-2">Player</th>
                                                <th class="py-2" style="width: 100px;">Position</th>
                                                <th class="py-2" style="width: 80px;">Nationality</th>
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
                                                                <img src="{{ asset($player->photo) }}"
                                                                     alt="{{ $player->first_name }}"
                                                                     class="rounded-circle"
                                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                                     onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg';">
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold">{{ $player->first_name }} {{ $player->last_name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="badge badge-secondary">{{ $player->position }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <small class="text-muted">{{ $player->nationality }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        No active players found for this team.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Away Team Players -->
                        <div class="col-md-6">
                            <div class="team-players-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-danger mb-0">
                                        <i class="fas fa-plane-departure mr-1"></i>
                                        {{ $match->awayTeam->name }}
                                    </h5>
                                    <span class="badge badge-danger">{{ $awayTeamPlayers->count() }} Players</span>
                                </div>

                                @if($awayTeamPlayers->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th class="py-2" style="width: 50px;">#</th>
                                                <th class="py-2">Player</th>
                                                <th class="py-2" style="width: 100px;">Position</th>
                                                <th class="py-2" style="width: 80px;">Nationality</th>
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
                                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                                     onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg';">
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold">{{ $player->first_name }} {{ $player->last_name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="badge badge-secondary">{{ $player->position }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <small class="text-muted">{{ $player->nationality }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        No active players found for this team.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Match Events Section -->
            @if($goals->count() > 0 || $yellowCards->count() > 0 || $redCards->count() > 0 || $otherEvents->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-history mr-2"></i> Match Events
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Goals -->
                        @if($goals->count() > 0)
                            <div class="mb-4">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-futbol mr-2"></i> Goals ({{ $goals->count() }})
                                </h5>
                                <div class="row">
                                    @foreach($goals as $goal)
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center p-2 border rounded bg-light">
                                                <span class="badge badge-success mr-3 px-3 py-2">{{ $goal->minute }}'</span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $goal->player->first_name }} {{ $goal->player->last_name }}
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-users mr-1"></i>
                                                        {{ $goal->team->name }}
                                                        @if($goal->description)
                                                            <span class="ml-2">- {{ $goal->description }}</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    <!-- Cards -->
                        <div class="row">
                            <!-- Yellow Cards -->
                            @if($yellowCards->count() > 0)
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-warning mb-3">
                                        <i class="fas fa-square mr-2"></i> Yellow Cards ({{ $yellowCards->count() }})
                                    </h5>
                                    @foreach($yellowCards as $card)
                                        <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                            <span class="badge badge-warning mr-3 px-3 py-2">{{ $card->minute }}'</span>
                                            <div>
                                                <div class="font-weight-bold">
                                                    {{ $card->player->first_name }} {{ $card->player->last_name }}
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-users mr-1"></i>
                                                    {{ $card->team->name }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        <!-- Red Cards -->
                            @if($redCards->count() > 0)
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-danger mb-3">
                                        <i class="fas fa-square mr-2"></i> Red Cards ({{ $redCards->count() }})
                                    </h5>
                                    @foreach($redCards as $card)
                                        <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                            <span class="badge badge-danger mr-3 px-3 py-2">{{ $card->minute }}'</span>
                                            <div>
                                                <div class="font-weight-bold">
                                                    {{ $card->player->first_name }} {{ $card->player->last_name }}
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-users mr-1"></i>
                                                    {{ $card->team->name }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Other Events -->
                        @if($otherEvents->count() > 0)
                            <div class="mb-4">
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-list-alt mr-2"></i> Other Events ({{ $otherEvents->count() }})
                                </h5>
                                <div class="row">
                                    @foreach($otherEvents as $event)
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <span class="badge badge-info mr-3 px-3 py-2">{{ $event->minute }}'</span>
                                                <div>
                                                    <div class="font-weight-bold text-capitalize">
                                                        {{ str_replace('_', ' ', $event->type) }}
                                                    </div>
                                                    <div class="text-muted">
                                                        {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                        @if($event->description)
                                                            <span class="ml-2">- {{ $event->description }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($match->status === 'finished' || $match->status === 'live')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-history fa-2x text-muted mb-3"></i>
                        <h5 class="text-muted">No Events Recorded</h5>
                        <p class="text-muted mb-0">No match events have been recorded for this game.</p>
                    </div>
                </div>
            @endif

        <!-- Match Statistics (Optional) -->
            @if($match->status === 'finished')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-bar mr-2"></i> Match Statistics
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded">
                                    <h3 class="text-primary">{{ $match->home_team_score ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Goals</p>
                                    <small class="text-muted">{{ $match->homeTeam->name }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded">
                                    <h3 class="text-primary">{{ $match->away_team_score ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Goals</p>
                                    <small class="text-muted">{{ $match->awayTeam->name }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded">
                                    <h3 class="text-primary">{{ $goals->count() }}</h3>
                                    <p class="text-muted mb-0">Total Goals</p>
                                    <small class="text-muted">in the match</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
