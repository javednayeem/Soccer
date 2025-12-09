@extends('layouts.site')
@section('title', 'Match Results')
@section('subtitle', 'Completed Matches')

@section('content')

    <div class="site-section bg-dark">
        <div class="container">

            @forelse($groupedResults as $month => $matches)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-white mb-1">{{ $month }}</h2>
                                <p class="text-light mb-0 opacity-75">Match Results</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary px-3 py-2 bg-primary text-white">
                                    <i class="mdi mdi-soccer mr-1"></i>
                                    {{ $matches->count() }} Match{{ $matches->count() > 1 ? 'es' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($matches as $match)
                    <div class="match-container mb-4">
                        <!-- Match Header -->
                        <div class="match-header">
                            <div class="match-date-display d-inline-block bg-dark text-white rounded overflow-hidden">
                                <div class="day-week bg-primary text-center py-1 px-3">
                                    {{ $match->match_date->format('D') }}
                                </div>
                                <div class="date-full text-center py-2 px-3">
                                    <span class="h5 mb-0">{{ $match->match_date->format('d') }}</span>
                                    <span class="mx-1">/</span>
                                    <span class="h5 mb-0">{{ $match->match_date->format('M') }}</span>
                                    <span class="mx-1">/</span>
                                    <span class="h5 mb-0">{{ $match->match_date->format('Y') }}</span>
                                </div>
                            </div>
                            <span class="match-league">{{ $match->league ? $match->league->name : 'Friendly Match' }}</span>
                        </div>

                        <!-- Match Info -->
                        <div class="match-info">
                            <!-- Home Team -->
                            <div class="team-section">
                                <span class="team-label">team</span>
                                <div class="team-info">
                                    <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                         alt="{{ $match->homeTeam->name }}"
                                         class="team-logo"
                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                    <span class="team-name">{{ $match->homeTeam->name }}</span>
                                </div>
                            </div>

                            <!-- Score Section -->
                            <div class="score-section">
                                <span class="foull-info">
                                    @if($match->match_week)
                                        Week {{ $match->match_week }}
                                    @else
                                        match
                                    @endif
                                </span>
                                <div class="score">
                                    @if($match->home_team_score !== null && $match->away_team_score !== null)
                                        <span class="score-home">{{ $match->home_team_score }}</span>
                                        <span class="score-separator">|</span>
                                        <span class="score-away">{{ $match->away_team_score }}</span>
                                    @else
                                        <span class="score-home">-</span>
                                        <span class="score-separator">|</span>
                                        <span class="score-away">-</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Away Team -->
                            <div class="team-section">
                                <span class="team-label">team</span>
                                <div class="team-info">
                                    <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                         alt="{{ $match->awayTeam->name }}"
                                         class="team-logo"
                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                    <span class="team-name">{{ $match->awayTeam->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Match Status -->
                        <div class="match-status">
                            {{ $match->status === 'live' ? 'LIVE' : 'FT' }}
                            @if($match->venue)
                                • <i class="mdi mdi-map-marker mr-1"></i>{{ $match->venue }}
                            @endif
                        </div>

                        <!-- Goal Scorers Section -->
                        @if($match->events->count() > 0)
                            <div class="goal-scorers-section">
                                <!-- Home Team Scorers -->
                                <div class="goal-scorers">
                                    <h3>Goal scorers</h3>
                                    @php
                                        $homeEvents = $match->events->filter(function($event) use ($match) {
                                            return optional($event->player)->team_id == $match->home_team_id;
                                        });
                                        $homeGoals = $homeEvents->where('type', 'goal');
                                        $homeAssists = $homeEvents->where('type', 'assist');
                                    @endphp

                                    @if($homeGoals->count() > 0)
                                        @foreach($homeGoals as $goal)
                                            <div class="scorer">
                                                {{ $goal->player->first_name ?? 'Unknown' }} {{ $goal->player->last_name ?? 'Player' }}
                                                @if($goal->minute)
                                                    ({{ $goal->minute }}')
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="scorer">-</div>
                                    @endif
                                </div>

                                <!-- Match Info -->
                                <div class="goal-scorers">
                                    <h3>Match info</h3>
                                    <div class="scorer">
                                        <i class="mdi mdi-clock-time-four-outline mr-1"></i>
                                        {{ $match->match_date->format('g:i A') }}
                                    </div>
                                    <div class="scorer">
                                        <i class="mdi mdi-trophy-outline mr-1"></i>
                                        {{ $match->league ? $match->league->name : 'Friendly' }}
                                    </div>
                                </div>

                                <!-- Away Team Scorers -->
                                <div class="goal-scorers">
                                    <h3>Goal scorers</h3>
                                    @php
                                        $awayEvents = $match->events->filter(function($event) use ($match) {
                                            return optional($event->player)->team_id == $match->away_team_id;
                                        });
                                        $awayGoals = $awayEvents->where('type', 'goal');
                                        $awayAssists = $awayEvents->where('type', 'assist');
                                    @endphp

                                    @if($awayGoals->count() > 0)
                                        @foreach($awayGoals as $goal)
                                            <div class="scorer">
                                                {{ $goal->player->first_name ?? 'Unknown' }} {{ $goal->player->last_name ?? 'Player' }}
                                                @if($goal->minute)
                                                    ({{ $goal->minute }}')
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="scorer">-</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Assists Section -->
                            <div class="goal-scorers-section mt-3">
                                <!-- Home Team Assists -->
                                <div class="goal-scorers">
                                    <h3>Assists</h3>
                                    @if($homeAssists->count() > 0)
                                        @foreach($homeAssists as $assist)
                                            <div class="scorer">
                                                {{ $assist->player->first_name ?? 'Unknown' }} {{ $assist->player->last_name ?? 'Player' }}
                                                @if($assist->minute)
                                                    ({{ $assist->minute }}')
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="scorer">-</div>
                                    @endif
                                </div>

                                <!-- Result Summary -->
                                <div class="goal-scorers">
                                    <h3>Result</h3>
                                    <div class="scorer">
                                        @if($match->home_team_score > $match->away_team_score)
                                            <span class="text-success">Home Win</span>
                                        @elseif($match->away_team_score > $match->home_team_score)
                                            <span class="text-success">Away Win</span>
                                        @else
                                            <span class="text-info">Draw</span>
                                        @endif
                                    </div>
                                    <div class="scorer">
                                        Total Goals: {{ $match->home_team_score + $match->away_team_score }}
                                    </div>
                                </div>

                                <!-- Away Team Assists -->
                                <div class="goal-scorers">
                                    <h3>Assists</h3>
                                    @if($awayAssists->count() > 0)
                                        @foreach($awayAssists as $assist)
                                            <div class="scorer">
                                                {{ $assist->player->first_name ?? 'Unknown' }} {{ $assist->player->last_name ?? 'Player' }}
                                                @if($assist->minute)
                                                    ({{ $assist->minute }}')
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="scorer">-</div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="goal-scorers-section">
                                <div class="goal-scorers text-center w-100">
                                    <h3>No match events recorded</h3>
                                    <div class="scorer">
                                        <i class="mdi mdi-information-outline mr-1"></i>
                                        Goal and assist data will appear here
                                    </div>
                                </div>
                            </div>
                    @endif

                    <!-- Sparkle Icon -->
                        <div class="sparkle-icon">
                            <i class="mdi mdi-soccer" style="font-size: 24px; color: #666;"></i>
                        </div>
                    </div>
                @endforeach

            @empty
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="mdi mdi-emoticon-sad-outline display-4 text-light"></i>
                        </div>
                        <h3 class="text-white">No Results Found</h3>
                        <p class="text-light opacity-75">No finished matches have been recorded yet.</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>

    <style>

    </style>

@endsection