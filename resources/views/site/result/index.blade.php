@extends('layouts.site')

@section('title', 'Match Results')
@section('subtitle', 'Completed Matches')

@section('content')

    <div class="site-section bg-dark text-light">
        <div class="container">

            @forelse($groupedResults as $month => $matches)
                <div class="row mb-4">
                    <div class="col-12 title-section">
                        <h2 class="heading">{{ $month }}</h2>
                    </div>
                </div>

                @foreach($matches as $match)
                    <div class="match-card bg-light p-4 rounded mb-3">
                        <div class="row align-items-center">

                            <!-- Live Indicator -->
                            @if($match->status === 'live')
                                <div class="col-12 mb-2">
                    <span class="badge badge-danger px-3 py-2 animate-pulse">
                        <i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                        LIVE NOW
                    </span>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="row align-items-center">
                                    <!-- Date and Time -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="text-center">
                                            <div class="date-box bg-primary text-white rounded p-2">
                                                <div class="month">{{ $match->match_date->format('M') }}</div>
                                                <div class="day">{{ $match->match_date->format('d') }}</div>
                                                <div class="year small">{{ $match->match_date->format('Y') }}</div>
                                            </div>
                                            <div class="time small text-muted mt-1">
                                                {{ $match->match_date->format('g:i A') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Teams and Score -->
                                    <div class="col-md-7 col-lg-7">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <!-- Home Team -->
                                            <div class="team text-center flex-fill">
                                                <div class="team-logo-container">
                                                    <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                                         alt="{{ $match->homeTeam->name }}"
                                                         class="img-fluid team-logo"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                </div>
                                                <h6 class="team-name mt-2 mb-1">{{ $match->homeTeam->name }}</h6>
                                                @if($match->homeTeam->short_name)
                                                    <small class="text-muted">{{ $match->homeTeam->short_name }}</small>
                                                @endif
                                            </div>

                                            <!-- Score Box -->
                                            <div class="score-container mx-3">
                                                @if($match->status === 'finished' && $match->home_team_score !== null && $match->away_team_score !== null)
                                                    <div class="score-box bg-dark text-white rounded px-4 py-2">
                                                        <div class="score-numbers">
                                                            <span class="home-score h4">{{ $match->home_team_score }}</span>
                                                            <span class="score-divider mx-2">-</span>
                                                            <span class="away-score h4">{{ $match->away_team_score }}</span>
                                                        </div>
                                                        <div class="score-status small mt-1">
                                                            @if($match->home_team_score > $match->away_team_score)
                                                                <span class="text-success">Home Win</span>
                                                            @elseif($match->away_team_score > $match->home_team_score)
                                                                <span class="text-success">Away Win</span>
                                                            @else
                                                                <span class="text-info">Draw</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @elseif($match->status === 'live')
                                                    <div class="score-box bg-danger text-white rounded px-4 py-2">
                                                        <div class="score-numbers">
                                                            <span class="home-score h4">{{ $match->home_team_score ?? 0 }}</span>
                                                            <span class="score-divider mx-2">-</span>
                                                            <span class="away-score h4">{{ $match->away_team_score ?? 0 }}</span>
                                                        </div>
                                                        <div class="score-status small mt-1">
                                                            <span class="animate-pulse">LIVE</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="score-box bg-secondary text-white rounded px-4 py-2">
                                                        <div class="score-placeholder">-</div>
                                                        <div class="score-status small mt-1">Pending</div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Away Team -->
                                            <div class="team text-center flex-fill">
                                                <div class="team-logo-container">
                                                    <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                                         alt="{{ $match->awayTeam->name }}"
                                                         class="img-fluid team-logo"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                </div>
                                                <h6 class="team-name mt-2 mb-1">{{ $match->awayTeam->name }}</h6>
                                                @if($match->awayTeam->short_name)
                                                    <small class="text-muted">{{ $match->awayTeam->short_name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- League and Venue -->
                                    <div class="col-md-3 col-lg-3">
                                        <div class="text-center">
                                            <div class="league-name font-weight-bold">
                                                {{ $match->league ? $match->league->name : 'Friendly' }}
                                            </div>
                                            @if($match->match_week)
                                                <div class="match-week small text-primary">
                                                    {{ $match->match_week }}
                                                </div>
                                            @endif
                                            <div class="venue small text-muted mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $match->venue ?? 'TBA' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <br>
                <br>
                <br>

            @empty
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <h3>No Results Found</h3>
                        <p class="text-muted">No finished matches have been recorded yet.</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>

@endsection
