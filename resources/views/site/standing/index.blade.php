@extends('layouts.site')
@section('title', 'League Standings')
@section('subtitle', $league ? $league->name . ' - ' . $league->season : '')

@section('content')

    <div class="site-section bg-dark text-light">
        <div class="container">

            @if(!$league)
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <h3>No Active League Found</h3>
                        <p>Please check back later.</p>
                    </div>
                </div>
            @else
                <div class="row mb-4">
                    <div class="col-12 title-section">
                        <h2 class="heading">{{ $league->name }} Standings</h2>
                    </div>
                </div>

                <div class="table-responsive standings-table">
                    <table class="table table-dark table-striped table-hover text-center align-middle">
                        <thead class="thead-light">
                        <tr>
                            <th>Position</th>
                            <th class="text-left">Team</th>
                            <th>Matches Played</th>
                            <th>Wins</th>
                            <th>Draws</th>
                            <th>Loss</th>
                            <th>Goals For</th>
                            <th>Goals Against</th>
                            <th>Goal Difference</th>
                            <th>PTS</th>
                            <th>Next</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($league->standings as $standing)
                            <tr>
                                <td>{{ $standing->position }}</td>

                                <td class="text-left">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('site/images/teams/' . $standing->team->logo) }}"
                                             alt="{{ $standing->team->name }}"
                                             class="standing-team-logo" style="width: 15%"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                        <span class="ml-2">{{ $standing->team->name }}</span>
                                    </div>
                                </td>

                                <td>{{ $standing->played }}</td>
                                <td>{{ $standing->won }}</td>
                                <td>{{ $standing->drawn }}</td>
                                <td>{{ $standing->lost }}</td>
                                <td>{{ $standing->goals_for }}</td>
                                <td>{{ $standing->goals_against }}</td>
                                <td>{{ $standing->goal_difference }}</td>
                                <td class="font-weight-bold text-primary">{{ $standing->points }}</td>
                                <td>
                                    @if($standing->next_match)
                                        @php
                                            $team = $standing->team;
                                            $match = $standing->next_match;
                                            $opponent = $match->home_team_id == $team->id ? $match->awayTeam : $match->homeTeam;
                                        @endphp

                                        <img src="{{ asset('site/images/teams/' . $opponent->logo) }}"
                                             alt="{{ $opponent->name }}"
                                             class="next-opponent-logo" style="width: 30%"
                                             data-toggle="tooltip"
                                             title="{{ $opponent->name }} — {{ $match->match_date->format('M j, g:i A') }}"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

@endsection
