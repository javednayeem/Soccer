@extends('layouts.site')

@section('title', 'Match Results')
@section('subtitle', 'Completed Matches')

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            @forelse($groupedResults as $month => $matches)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-dark mb-1">{{ $month }}</h2>
                                <p class="text-secondary mb-0">Match Results</p>
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
                    <div class="card border-0 shadow-sm mb-4">
                        <!-- Match Header -->
                        <div class="card-header bg-primary text-white py-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="date-badge bg-white text-dark rounded px-3 py-2 mr-3">
                                            <div class="text-center">
                                                <div class="fw-bold">{{ $match->match_date->format('M j') }}</div>
                                                <small>{{ $match->match_date->format('Y') }}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $match->league ? $match->league->name : 'Friendly Match' }}</h5>
                                            <small>
                                                <i class="mdi mdi-clock-outline mr-1"></i>
                                                {{ $match->match_date->format('g:i A') }}
                                                @if($match->match_week)
                                                    • Week {{ $match->match_week }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    @if($match->status === 'live')
                                        <span class="badge badge-danger animate-pulse px-3 py-2">
                                        <i class="mdi mdi-circle-small mr-1"></i>
                                        LIVE
                                    </span>
                                    @else
                                        <span class="badge badge-success px-3 py-2">
                                        <i class="mdi mdi-check-circle mr-1"></i>
                                        FINISHED
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Teams and Score -->
                            <div class="row align-items-center mb-4">
                                <!-- Home Team -->
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                             alt="{{ $match->homeTeam->name }}"
                                             class="rounded-circle border border-secondary mb-3"
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                        <h5 class="fw-bold text-dark mb-1">{{ $match->homeTeam->name }}</h5>
                                        @if($match->homeTeam->short_name)
                                            <small class="text-muted">{{ $match->homeTeam->short_name }}</small>
                                        @endif
                                    </div>
                                </div>

                                <!-- Score -->
                                <div class="col-md-4 text-center">
                                    @if($match->home_team_score !== null && $match->away_team_score !== null)
                                        <div class="score-display">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="display-3 fw-bold text-dark">{{ $match->home_team_score }}</span>
                                                <span class="mx-4 h2 text-muted">-</span>
                                                <span class="display-3 fw-bold text-dark">{{ $match->away_team_score }}</span>
                                            </div>
                                            <div class="mt-2">
                                                @if($match->home_team_score > $match->away_team_score)
                                                    <span class="badge badge-success px-3 py-1">Home Win</span>
                                                @elseif($match->away_team_score > $match->home_team_score)
                                                    <span class="badge badge-success px-3 py-1">Away Win</span>
                                                @else
                                                    <span class="badge badge-info px-3 py-1">Draw</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-muted">No score recorded</div>
                                    @endif
                                </div>

                                <!-- Away Team -->
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                             alt="{{ $match->awayTeam->name }}"
                                             class="rounded-circle border border-secondary mb-3"
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                        <h5 class="fw-bold text-dark mb-1">{{ $match->awayTeam->name }}</h5>
                                        @if($match->awayTeam->short_name)
                                            <small class="text-muted">{{ $match->awayTeam->short_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Venue -->
                            <div class="text-center mb-4">
                                <small class="text-muted">
                                    <i class="mdi mdi-map-marker text-danger mr-1"></i>
                                    {{ $match->venue ?? 'Venue TBA' }}
                                </small>
                            </div>

                            <!-- Goals and Assists Section -->
                            @if($match->events->count() > 0)
                                <div class="match-events border-top pt-4">
                                    <h6 class="text-center mb-3 text-dark">
                                        <i class="mdi mdi-soccer mr-2"></i>
                                        Match Events
                                    </h6>

                                    <div class="row">
                                        <!-- Home Team Events -->
                                        <div class="col-md-6">
                                            <div class="team-events">
                                                <h6 class="fw-bold text-primary mb-3">{{ $match->homeTeam->name }} Events</h6>
                                                @php
                                                    $homeEvents = $match->events->filter(function($event) use ($match) {
                                                        return optional($event->player)->team_id == $match->home_team_id;
                                                    });
                                                @endphp

                                                @if($homeEvents->count() > 0)
                                                    <div class="events-list">
                                                        @foreach($homeEvents as $event)
                                                            <div class="event-item mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="event-type-badge me-2">
                                                                        @if($event->type == 'goal')
                                                                            <span class="badge badge-success px-2 py-1 mr-1">⚽ Goal</span>
                                                                        @elseif($event->type == 'assist')
                                                                            <span class="badge badge-primary px-2 py-1 mr-1">🅰️ Assist</span>
                                                                        @else
                                                                            <span class="badge badge-secondary px-2 py-1">{{ ucfirst(str_replace('_', ' ', $event->type)) }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="event-details">
                                                                        <span class="fw-semibold">{{ $event->player->first_name ?? 'Unknown' }} {{ $event->player->last_name ?? 'Player' }}</span>
                                                                        <small class="text-muted ms-2">({{ $event->minute ?? 'N/A' }}')</small>
                                                                    </div>
                                                                </div>
                                                                @if($event->description)
                                                                    <small class="text-muted d-block mt-1">{{ $event->description }}</small>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted small">No events recorded</p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Away Team Events -->
                                        <div class="col-md-6">
                                            <div class="team-events">
                                                <h6 class="fw-bold text-primary mb-3">{{ $match->awayTeam->name }} Events</h6>
                                                @php
                                                    $awayEvents = $match->events->filter(function($event) use ($match) {
                                                        return optional($event->player)->team_id == $match->away_team_id;
                                                    });
                                                @endphp

                                                @if($awayEvents->count() > 0)
                                                    <div class="events-list">
                                                        @foreach($awayEvents as $event)
                                                            <div class="event-item mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="event-type-badge me-2">
                                                                        @if($event->type == 'goal')
                                                                            <span class="badge badge-success px-2 py-1 mr-1">⚽ Goal</span>
                                                                        @elseif($event->type == 'assist')
                                                                            <span class="badge badge-primary px-2 py-1 mr-1">🅰️ Assist</span>
                                                                        @else
                                                                            <span class="badge badge-secondary px-2 py-1">{{ ucfirst(str_replace('_', ' ', $event->type)) }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="event-details">
                                                                        <span class="fw-semibold">{{ $event->player->first_name ?? 'Unknown' }} {{ $event->player->last_name ?? 'Player' }}</span>
                                                                        <small class="text-muted ms-2">({{ $event->minute ?? 'N/A' }}')</small>
                                                                    </div>
                                                                </div>
                                                                @if($event->description)
                                                                    <small class="text-muted d-block mt-1">{{ $event->description }}</small>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted small">No events recorded</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Goals and Assists Summary -->
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="summary-card bg-success-light p-3 rounded">
                                                <h6 class="fw-bold text-success">
                                                    <i class="mdi mdi-soccer mr-2"></i>
                                                    Goals
                                                </h6>
                                                <div class="d-flex justify-content-between">
                                                    <span>{{ $homeEvents->where('type', 'goal')->count() }}</span>
                                                    <span class="fw-bold">{{ $match->homeTeam->short_name ?? $match->homeTeam->name }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>{{ $awayEvents->where('type', 'goal')->count() }}</span>
                                                    <span class="fw-bold">{{ $match->awayTeam->short_name ?? $match->awayTeam->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="summary-card bg-primary-light p-3 rounded">
                                                <h6 class="fw-bold text-primary">
                                                    <i class="mdi mdi-hand-pointing-right mr-2"></i>
                                                    Assists
                                                </h6>
                                                <div class="d-flex justify-content-between">
                                                    <span>{{ $homeEvents->where('type', 'assist')->count() }}</span>
                                                    <span class="fw-bold">{{ $match->homeTeam->short_name ?? $match->homeTeam->name }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>{{ $awayEvents->where('type', 'assist')->count() }}</span>
                                                    <span class="fw-bold">{{ $match->awayTeam->short_name ?? $match->awayTeam->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3 border-top">
                                    <p class="text-muted mb-0">
                                        <i class="mdi mdi-information-outline mr-1"></i>
                                        No match events recorded
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            @empty
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="mdi mdi-emoticon-sad-outline display-4 text-muted"></i>
                        </div>
                        <h3 class="text-dark">No Results Found</h3>
                        <p class="text-muted">No finished matches have been recorded yet.</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>

@endsection
