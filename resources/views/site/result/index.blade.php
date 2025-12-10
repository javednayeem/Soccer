@extends('layouts.site')
@section('title', 'Match Results')
@section('subtitle', 'Completed Matches')

@section('content')

    <div class="site-section bg-dark">
        <div class="container">

            @forelse($groupedResults as $month => $matches)
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-white mb-0" style="font-size: 1.5rem">{{ $month }}</h2>
                                <p class="text-light mb-0 opacity-75 small">Match Results</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary px-2 py-1 bg-primary text-white small">
                                    <i class="mdi mdi-soccer mr-1"></i>
                                    {{ $matches->count() }} Match{{ $matches->count() > 1 ? 'es' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($matches as $match)
                    <div class="match-container mb-3" style="border: 1px solid #333; border-radius: 8px; overflow: hidden;">
                        <!-- Match Header - Grouped Info -->
                        <div class="match-header" style="background: #222; padding: 0.75rem 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <div class="d-flex align-items-center">
                                <!-- Date Display -->
                                <div class="match-date-display d-inline-flex align-items-center bg-dark text-white rounded overflow-hidden mr-3">
                                    <div class="day-week bg-primary text-center py-0 px-2" style="font-size: 0.8rem;">
                                        {{ $match->match_date->format('D') }}
                                    </div>
                                    <div class="date-full text-center py-1 px-2 d-flex align-items-center">
                                        <span class="h6 mb-0">{{ $match->match_date->format('d') }}</span>
                                        <span class="mx-1">/</span>
                                        <span class="h6 mb-0">{{ $match->match_date->format('M') }}</span>
                                        <span class="mx-1">/</span>
                                        <span class="h6 mb-0">{{ $match->match_date->format('Y') }}</span>
                                    </div>
                                </div>

                                <!-- Match Info Group -->
                                <div class="d-flex align-items-center">
                                    <span class="match-status mr-2 small" style="color: #4CAF50; font-weight: bold;">
                                        {{ $match->status === 'live' ? 'LIVE' : 'FT' }}
                                    </span>
                                    <span class="match-time mr-3 small text-muted">
                                        <i class="mdi mdi-clock-time-four-outline mr-1"></i>
                                        {{ $match->match_date->format('g:i A') }}
                                    </span>
                                    @if($match->venue)
                                        <span class="match-venue small text-muted">
                                            <i class="mdi mdi-map-marker mr-1"></i>{{ $match->venue }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <span class="match-league small mr-2">{{ $match->league ? $match->league->name : 'Friendly Match' }}</span>
                                @if($match->match_week)
                                    <span class="badge badge-secondary px-2 py-1 small">
                                        Week {{ $match->match_week }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Match Info -->
                        <div class="match-info" style="padding: 1rem; background: #1a1a1a; display: flex; align-items: center;">
                            <!-- Home Team -->
                            <div class="team-section" style="flex: 1;">
                                <div class="team-info d-flex align-items-center justify-content-start">
                                    <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                         alt="{{ $match->homeTeam->name }}"
                                         class="team-logo" style="width: 40px; height: 40px; margin-right: 0.75rem;"
                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                    <div>
                                        <span class="team-label small text-muted d-block mb-1">Home Team</span>
                                        <span class="team-name" style="font-weight: 500;">{{ $match->homeTeam->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Score Section -->
                            <div class="score-section" style="flex: 0 0 auto; text-align: center;">
                                <div class="score">
                                    @if($match->home_team_score !== null && $match->away_team_score !== null)
                                        <span class="score-home h2 mb-0" style="font-weight: bold;">{{ $match->home_team_score }}</span>
                                        <span class="score-separator h3 mb-0 mx-2" style="color: #666;">-</span>
                                        <span class="score-away h2 mb-0" style="font-weight: bold;">{{ $match->away_team_score }}</span>
                                    @else
                                        <span class="score-home h3 mb-0">-</span>
                                        <span class="score-separator mx-2">-</span>
                                        <span class="score-away h3 mb-0">-</span>
                                    @endif
                                </div>
                                <div class="result-summary small mt-1">
                                    @if($match->home_team_score !== null && $match->away_team_score !== null)
                                        @if($match->home_team_score > $match->away_team_score)
                                            <span class="text-success">Home Win</span>
                                        @elseif($match->away_team_score > $match->home_team_score)
                                            <span class="text-success">Away Win</span>
                                        @else
                                            <span class="text-info">Draw</span>
                                        @endif
                                        • Total Goals: {{ $match->home_team_score + $match->away_team_score }}
                                    @endif
                                </div>
                            </div>

                            <!-- Away Team -->
                            <div class="team-section" style="flex: 1; text-align: right;">
                                <div class="team-info d-flex align-items-center justify-content-end">
                                    <div class="text-right mr-2">
                                        <span class="team-label small text-muted d-block mb-1">Away Team</span>
                                        <span class="team-name" style="font-weight: 500;">{{ $match->awayTeam->name }}</span>
                                    </div>
                                    <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                         alt="{{ $match->awayTeam->name }}"
                                         class="team-logo" style="width: 40px; height: 40px;"
                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                </div>
                            </div>
                        </div>

                        <!-- Goal Scorers Section -->
                        @if($match->events->count() > 0)
                            <div class="goal-scorers-section" style="padding: 1rem; background: #1a1a1a; border-top: 1px solid #333;">
                                <div class="row">
                                    <!-- Home Team Scorers -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Home Goal Scorers</h3>
                                        @php
                                            $homeEvents = $match->events->filter(function($event) use ($match) {
                                                return optional($event->player)->team_id == $match->home_team_id;
                                            });
                                            $homeGoals = $homeEvents->where('type', 'goal');
                                        @endphp

                                        @if($homeGoals->count() > 0)
                                            @foreach($homeGoals as $goal)
                                                <div class="scorer small mb-1">
                                                    {{ $goal->player->first_name ?? 'Unknown' }} {{ $goal->player->last_name ?? 'Player' }}
                                                    @if($goal->minute)
                                                        <span class="text-muted">({{ $goal->minute }}')</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="scorer small text-muted mb-1">-</div>
                                        @endif
                                    </div>

                                    <!-- Match Type/League -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Match Details</h3>
                                        <div class="scorer small mb-1">
                                            <i class="mdi mdi-trophy-outline mr-1"></i>
                                            {{ $match->league ? $match->league->name : 'Friendly' }}
                                        </div>
                                        <div class="scorer small mb-1">
                                            @if($match->home_team_score !== null && $match->away_team_score !== null)
                                                {{ $match->home_team_score }} - {{ $match->away_team_score }}
                                            @else
                                                TBD
                                            @endif
                                        </div>
                                        @if($match->match_week)
                                            <div class="scorer small mb-1">
                                                Week {{ $match->match_week }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Away Team Scorers -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Away Goal Scorers</h3>
                                        @php
                                            $awayEvents = $match->events->filter(function($event) use ($match) {
                                                return optional($event->player)->team_id == $match->away_team_id;
                                            });
                                            $awayGoals = $awayEvents->where('type', 'goal');
                                        @endphp

                                        @if($awayGoals->count() > 0)
                                            @foreach($awayGoals as $goal)
                                                <div class="scorer small mb-1">
                                                    {{ $goal->player->first_name ?? 'Unknown' }} {{ $goal->player->last_name ?? 'Player' }}
                                                    @if($goal->minute)
                                                        <span class="text-muted">({{ $goal->minute }}')</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="scorer small text-muted mb-1">-</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Assists Section -->
                            <div class="goal-scorers-section" style="padding: 1rem; background: #1a1a1a; border-top: 1px solid #333;">
                                <div class="row">
                                    <!-- Home Team Assists -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Home Assists</h3>
                                        @php
                                            $homeAssists = $homeEvents->where('type', 'assist');
                                        @endphp
                                        @if($homeAssists->count() > 0)
                                            @foreach($homeAssists as $assist)
                                                <div class="scorer small mb-1">
                                                    {{ $assist->player->first_name ?? 'Unknown' }} {{ $assist->player->last_name ?? 'Player' }}
                                                    @if($assist->minute)
                                                        <span class="text-muted">({{ $assist->minute }}')</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="scorer small text-muted mb-1">-</div>
                                        @endif
                                    </div>

                                    <!-- Result Summary -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Result Summary</h3>
                                        <div class="scorer small mb-1">
                                            @if($match->home_team_score > $match->away_team_score)
                                                <span class="text-success">🏆 Home Team Victory</span>
                                            @elseif($match->away_team_score > $match->home_team_score)
                                                <span class="text-success">🏆 Away Team Victory</span>
                                            @else
                                                <span class="text-info">🤝 Match Drawn</span>
                                            @endif
                                        </div>
                                        @if($match->home_team_score !== null && $match->away_team_score !== null)
                                            <div class="scorer small mb-1">
                                                Goals: {{ $match->home_team_score + $match->away_team_score }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Away Team Assists -->
                                    <div class="col-md-4 text-center">
                                        <h3 class="h6 mb-2" style="color: #999;">Away Assists</h3>
                                        @php
                                            $awayAssists = $awayEvents->where('type', 'assist');
                                        @endphp
                                        @if($awayAssists->count() > 0)
                                            @foreach($awayAssists as $assist)
                                                <div class="scorer small mb-1">
                                                    {{ $assist->player->first_name ?? 'Unknown' }} {{ $assist->player->last_name ?? 'Player' }}
                                                    @if($assist->minute)
                                                        <span class="text-muted">({{ $assist->minute }}')</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="scorer small text-muted mb-1">-</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="goal-scorers-section" style="padding: 1rem; background: #1a1a1a; border-top: 1px solid #333;">
                                <div class="text-center">
                                    <h3 class="h6 mb-1" style="color: #999;">No match events recorded</h3>
                                    <div class="scorer small text-muted mb-0">
                                        <i class="mdi mdi-information-outline mr-1"></i>
                                        Goal and assist data will appear here
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

            @empty
                <div class="row">
                    <div class="col-12 text-center py-4">
                        <div class="mb-3">
                            <i class="mdi mdi-emoticon-sad-outline display-4 text-light"></i>
                        </div>
                        <h3 class="text-white h5">No Results Found</h3>
                        <p class="text-light opacity-75 small">No finished matches have been recorded yet.</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>

    <style>
        /* Override the CSS that's causing alignment issues */
        .goal-scorers-section {
            display: block !important;
            grid-template-columns: none !important;
        }

        .goal-scorers h3 {
            text-align: center !important;
        }

        .scorer {
            text-align: center !important;
            display: block !important;
        }

        .match-container .row {
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .match-container .col-md-4 {
            flex: 0 0 33.333333% !important;
            max-width: 33.333333% !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        /* Make sure text is centered */
        .match-container .text-center {
            text-align: center !important;
        }

        /* Remove any leftover inline styles that might affect alignment */
        .match-container .goal-scorers-section .col-md-4 * {
            text-align: center !important;
        }
    </style>

@endsection