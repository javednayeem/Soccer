@extends('layouts.site')
@section('title', 'League Standings')
@section('subtitle', $league ? $league->name . ' - ' . $league->season : '')

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            @if(!$league)
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <h3 class="text-dark">No Active League Found</h3>
                        <p class="text-muted">Please check back later.</p>
                    </div>
                </div>
            @else
            <!-- League Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-dark mb-1">{{ $league->name }} Standings</h2>
                                <p class="text-secondary mb-0">{{ $league->season }} • {{ $league->subtitle }}</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-success px-3 py-2 bg-success text-white">
                                    <i class="mdi mdi-calendar-range mr-1"></i>
                                    {{ \Carbon\Carbon::parse($league->start_date)->format('M j') }} - {{ \Carbon\Carbon::parse($league->end_date)->format('M j, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Standings Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless mb-0">
                                <thead class="thead-light">
                                <tr class="bg-primary text-white">
                                    <th class="text-center py-3 border-0" style="width: 60px;">#</th>
                                    <th class="py-3 border-0">Team</th>
                                    <th class="text-center py-3 border-0" style="width: 80px;">MP</th>
                                    <th class="text-center py-3 border-0" style="width: 60px;">W</th>
                                    <th class="text-center py-3 border-0" style="width: 60px;">D</th>
                                    <th class="text-center py-3 border-0" style="width: 60px;">L</th>
                                    <th class="text-center py-3 border-0" style="width: 70px;">GF</th>
                                    <th class="text-center py-3 border-0" style="width: 70px;">GA</th>
                                    <th class="text-center py-3 border-0" style="width: 70px;">GD</th>
                                    <th class="text-center py-3 border-0" style="width: 80px;">
                                        <strong>PTS</strong>
                                    </th>
                                    <th class="text-center py-3 border-0" style="width: 80px;">Next</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($league->standings as $standing)
                                    <tr class="border-bottom {{ $loop->first ? 'bg-success-light' : ($loop->index < 4 ? 'bg-info-light' : '') }}">
                                        <!-- Position -->
                                        <td class="text-center align-middle py-3">
                                            @if($standing->position <= 3)
                                                <span class="badge badge-success badge-pill d-inline-flex align-items-center justify-content-center text-white"
                                                      style="width: 32px; height: 32px; font-size: 14px; font-weight: bold;">
                                                    {{ $standing->position }}
                                                </span>
                                            @else
                                                <span class="text-dark fw-bold" style="font-size: 16px;">
                                                    {{ $standing->position }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Team -->
                                        <td class="align-middle py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('site/images/teams/' . $standing->team->logo) }}"
                                                         alt="{{ $standing->team->name }}"
                                                         class="rounded-circle border border-secondary"
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0 text-dark fw-bold ml-2"><a href="/team/{{ $standing->team->id }}/players" class="text-dark" style="text-decoration: none">{{ $standing->team->name }}</a></h6>
                                                    @if($standing->team->short_name)
                                                        <small class="text-muted ml-2">{{ $standing->team->short_name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Stats -->
                                        <td class="text-center align-middle py-3">
                                            <span class="text-dark fw-semibold">{{ $standing->played }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="text-success fw-bold">{{ $standing->won }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="text-warning fw-bold">{{ $standing->drawn }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="text-danger fw-bold">{{ $standing->lost }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="text-info fw-bold">{{ $standing->goals_for }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="text-danger fw-bold">{{ $standing->goals_against }}</span>
                                        </td>
                                        <td class="text-center align-middle py-3">
                                            <span class="fw-bold {{ $standing->goal_difference > 0 ? 'text-success' : ($standing->goal_difference < 0 ? 'text-danger' : 'text-dark') }}">
                                                {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                            </span>
                                        </td>

                                        <!-- Points -->
                                        <td class="text-center align-middle py-3">
                                            <span class="badge badge-primary px-3 py-2 fw-bold text-white" style="font-size: 14px;">
                                                {{ $standing->points }}
                                            </span>
                                        </td>

                                        <!-- Next Match -->
                                        <td class="text-center align-middle py-3">
                                            @if($standing->next_match)
                                                @php
                                                    $team = $standing->team;
                                                    $match = $standing->next_match;
                                                    $opponent = $match->home_team_id == $team->id ? $match->awayTeam : $match->homeTeam;
                                                    $isHome = $match->home_team_id == $team->id;
                                                @endphp

                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="{{ asset('site/images/teams/' . $opponent->logo) }}"
                                                         alt="{{ $opponent->name }}"
                                                         class="rounded-circle border border-secondary"
                                                         style="width: 35px; height: 35px; object-fit: cover;"
                                                         data-toggle="tooltip"
                                                         title="{{ $opponent->name }} — {{ $match->match_date->format('M j, g:i A') }}"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                    <small class="text-muted mt-1">
                                                        {{ $isHome ? 'H' : 'A' }}
                                                    </small>
                                                </div>
                                            @else
                                                <span class="text-muted fst-italic">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endif

        </div>
    </div>

@endsection
