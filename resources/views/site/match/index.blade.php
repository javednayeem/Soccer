@extends('layouts.site')
@section('title', 'Matches')
@section('subtitle', 'Stay updated with our latest matches, results, and upcoming fixtures. Follow our team\'s journey through the season.')

@section('content')

    @if($recentMatches->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-12 title-section mb-4">
                    <h2 class="heading">Recent Matches</h2>
                </div>
                @foreach($recentMatches as $match)
                    <div class="col-lg-12 mb-4">
                        <div class="d-flex team-vs">
                        <span class="score">
                            {{ isset($match->home_team_score) ? $match->home_team_score : '0' }} -
                            {{ isset($match->away_team_score) ? $match->away_team_score : '0' }}
                        </span>

                            <div class="team-1 w-50">
                                <div class="team-details w-100 text-center">
                                    <img src="/site/images/teams/{{ $match->homeTeam->logo }}"
                                         alt="{{ $match->homeTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                    <h3>{{ $match->homeTeam->name }}
                                        <span class="{{ $match->home_team_score > $match->away_team_score ? 'text-success' : 'text-danger' }}">
                                        ({{ $match->home_team_score > $match->away_team_score ? 'win' : ($match->home_team_score == $match->away_team_score ? 'draw' : 'loss') }})
                                    </span>
                                    </h3>
                                    @if($match->scorers)
                                        <ul class="list-unstyled">
                                            @foreach($match->scorers as $scorer)
                                                @if($scorer['team'] == 'home')
                                                    <li>{{ $scorer['player_name'] }} ({{ $scorer['minute'] }})</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="team-2 w-50">
                                <div class="team-details w-100 text-center">
                                    <img src="/site/images/teams/{{ $match->awayTeam->logo }}"
                                         alt="{{ $match->awayTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                    <h3>{{ $match->awayTeam->name }}
                                        <span class="{{ $match->away_team_score > $match->home_team_score ? 'text-success' : 'text-danger' }}">
                                        ({{ $match->away_team_score > $match->home_team_score ? 'win' : ($match->away_team_score == $match->home_team_score ? 'draw' : 'loss') }})
                                    </span>
                                    </h3>
                                    @if($match->scorers)
                                        <ul class="list-unstyled">
                                            @foreach($match->scorers as $scorer)
                                                @if($scorer['team'] == 'away')
                                                    <li>{{ $scorer['player_name'] }} ({{ $scorer['minute'] }})</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y') }} •
                                {{ isset($match->venue) ? $match->venue : 'TBA' }} •
                                {{ isset($match->competition) ? $match->competition : 'Friendly' }}
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="site-section bg-dark">
        <div class="container">
            @if($nextMatch)
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="widget-next-match">
                            <div class="widget-title">
                                <h3>Next Match</h3>
                            </div>
                            <div class="widget-body mb-3">
                                <div class="widget-vs">
                                    <div class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                        <div class="team-1 text-center">
                                            <img src="/site/images/teams/{{ $nextMatch->homeTeam->logo }}"
                                                 alt="{{ $nextMatch->homeTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                            <h3>{{ $nextMatch->homeTeam->name }}</h3>
                                        </div>
                                        <div>
                                            <span class="vs"><span>VS</span></span>
                                        </div>
                                        <div class="team-2 text-center">
                                            <img src="/site/images/teams/{{ $nextMatch->awayTeam->logo }}"
                                                 alt="{{ $nextMatch->awayTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                            <h3>{{ $nextMatch->awayTeam->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center widget-vs-contents mb-4">
                                <h4>{{ isset($nextMatch->competition) ? $nextMatch->competition : 'Friendly Match' }}</h4>
                                <p class="mb-5">
                                    <span class="d-block">{{ \Carbon\Carbon::parse($nextMatch->match_date)->format('F jS, Y') }}</span>
                                    <span class="d-block">
                                    {{ \Carbon\Carbon::parse(isset($nextMatch->match_time) ? $nextMatch->match_time : $nextMatch->match_date)->format('g:i A') }}
                                </span>
                                    <strong class="text-primary">{{ isset($nextMatch->venue) ? $nextMatch->venue : 'Venue TBA' }}</strong>
                                </p>

                                @if($nextMatch->match_date > now())
                                    <div id="date-countdown2" class="pb-1" data-countdown="{{ $nextMatch->match_date->format('Y/m/d H:i:s') }}"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($upcomingMatches->count() > 0)
                <div class="row">
                    <div class="col-12 title-section">
                        <h2 class="heading">Upcoming Matches</h2>
                    </div>
                    @foreach($upcomingMatches as $match)
                        <div class="col-lg-6 mb-4">
                            <div class="bg-light p-4 rounded">
                                <div class="widget-body">
                                    <div class="widget-vs">
                                        <div class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                            <div class="team-1 text-center">
                                                <img src="/site/images/teams/{{ $match->homeTeam->logo }}"
                                                     alt="{{ $match->homeTeam->name }}" class="img-fluid" style="max-height: 60px;">
                                                <h3>{{ $match->homeTeam->name }}</h3>
                                            </div>
                                            <div>
                                                <span class="vs"><span>VS</span></span>
                                            </div>
                                            <div class="team-2 text-center">
                                                <img src="/site/images/teams/{{ $match->awayTeam->logo }}"
                                                     alt="{{ $match->awayTeam->name }}" class="img-fluid" style="max-height: 60px;">
                                                <h3>{{ $match->awayTeam->name }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center widget-vs-contents mb-4">
                                    <h4>{{ isset($match->competition) ? $match->competition : 'Friendly Match' }}</h4>
                                    <p class="mb-5">
                                        <span class="d-block">{{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y') }}</span>
                                        <span class="d-block">
                                        {{ \Carbon\Carbon::parse(isset($match->match_time) ? $match->match_time : $match->match_date)->format('g:i A') }}
                                    </span>
                                        <strong class="text-primary">{{ isset($match->venue) ? $match->venue : 'Venue TBA' }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <h4 class="text-light">No upcoming matches scheduled</h4>
                        <p class="text-muted">Check back later for updates on our next fixtures.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection