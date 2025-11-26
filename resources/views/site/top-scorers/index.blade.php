@extends('layouts.site')
@section('title', 'Top Scorers')
@section('subtitle', $league->name . ' - ' . $league->season)

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="heading text-dark mb-1">Top Scorers</h2>
                            <p class="text-secondary mb-0">{{ $league->name }} • {{ $league->season }}</p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-success px-3 py-2 bg-success text-white">
                                <i class="mdi mdi-soccer mr-1"></i>
                                {{ count($playerStatistics) }} Players
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Scorers Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <thead class="thead-light">
                            <tr class="bg-primary text-white">
                                <th class="text-center py-3 border-0" style="width: 70px;">#</th>
                                <th class="py-3 border-0">Player</th>
                                <th class="py-3 border-0">Team</th>
                                <th class="text-center py-3 border-0" style="width: 100px;">
                                    <strong>Goals</strong>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($playerStatistics as $index => $stat)
                                <tr class="border-bottom {{ $index < 3 ? 'bg-warning-light' : '' }}">
                                    <!-- Position -->
                                    <td class="text-center align-middle py-3">
                                        @if($index == 0)
                                            <span class="badge badge-warning badge-pill d-inline-flex align-items-center justify-content-center text-dark"
                                                  style="width: 36px; height: 36px; font-size: 16px; font-weight: bold;">
                                                {{ $index + 1 }}
                                                <i class="mdi mdi-crown ml-1" style="font-size: 14px;"></i>
                                            </span>
                                        @elseif($index < 3)
                                            <span class="badge badge-success badge-pill d-inline-flex align-items-center justify-content-center text-white"
                                                  style="width: 32px; height: 32px; font-size: 14px; font-weight: bold;">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            <span class="text-dark fw-bold" style="font-size: 16px;">
                                                {{ $index + 1 }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Player -->
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ str_contains($stat->player->photo, 'site/images/players/') ? asset($stat->player->photo) : asset('site/images/players/' . $stat->player->photo) }}"
                                                     alt="{{ $stat->player->first_name }} {{ $stat->player->last_name }}"
                                                     class="rounded-circle border border-secondary"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     onerror="this.onerror=null; this.src='{{ asset('site/images/players/default_player.jpg') }}';">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 text-dark fw-bold ml-2">
                                                    {{ $stat->player->first_name }} {{ $stat->player->last_name }}
                                                </h6>
                                                <div class="d-flex align-items-center ml-2">
                                                    <span class="badge badge-secondary badge-sm me-2">
                                                        #{{ $stat->player->jersey_number ?: 'N/A' }}
                                                    </span>
                                                    <span class="text-muted small">
                                                        {{ ucfirst($stat->player->position) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Team -->
                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('site/images/teams/' . $stat->player->team->logo) }}"
                                                     alt="{{ $stat->player->team->name }}"
                                                     class="rounded-circle border border-secondary"
                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="text-dark fw-semibold d-block">
                                                    {{ $stat->player->team->short_name ?: $stat->player->team->name }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $stat->player->team->name }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Goals -->
                                    <td class="text-center align-middle py-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge badge-danger px-3 py-2 fw-bold text-white" style="font-size: 16px;">
                                                {{ $stat->goals }}
                                            </span>
                                            <small class="text-muted mt-1">
                                                @if($stat->matches_played)
                                                    {{ $stat->matches_played }} games
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Stats Summary -->
            @if(!$playerStatistics->isEmpty())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h4 class="text-primary mb-1">{{ $playerStatistics->sum('goals') }}</h4>
                                        <small class="text-muted">Total Goals</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-success mb-1">{{ $playerStatistics->count() }}</h4>
                                        <small class="text-muted">Players</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-info mb-1">{{ $playerStatistics->first()->goals ?? 0 }}</h4>
                                        <small class="text-muted">Top Scorer</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-warning mb-1">
                                            {{ $playerStatistics->avg('goals') ? number_format($playerStatistics->avg('goals'), 1) : '0.0' }}
                                        </h4>
                                        <small class="text-muted">Avg per Player</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
