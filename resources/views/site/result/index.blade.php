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

                            <!-- Date -->
                            <div class="col-md-2 text-center text-white">
                                <div class="match-date">
                                    {{ $match->match_date->format('M j, Y') }}<br>
                                    <span class="small">{{ $match->match_date->format('g:i A') }}</span>
                                </div>
                            </div>

                            <!-- Teams + Result -->
                            <div class="col-md-7">
                                <div class="d-flex align-items-center justify-content-between">

                                    <!-- Home -->
                                    <div class="team text-center">
                                        <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                             class="result-team-logo" style="width: 30%"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                        <h5 class="text-white mt-2">{{ $match->homeTeam->name }}</h5>
                                    </div>

                                    <!-- Score -->
                                    <div class="score-box text-white">
                                    <span class="score-number">
                                        {{ $match->home_team_score }} - {{ $match->away_team_score }}
                                    </span>
                                    </div>

                                    <!-- Away -->
                                    <div class="team text-center">
                                        <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                             class="result-team-logo" style="width: 30%"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                        <h5 class="text-white mt-2">{{ $match->awayTeam->name }}</h5>
                                    </div>

                                </div>
                            </div>

                            <!-- League -->
                            <div class="col-md-3 text-center text-white">
                                <div class="league-name">
                                    {{ $match->league ? $match->league->name : 'Friendly' }}
                                </div>
                                <div class="venue small text-muted">
                                    {{ $match->venue }}
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
