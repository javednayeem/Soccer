@extends('layouts.admin')
@section('title', 'Football Club Dashboard')

@section('content')

    <div class="row">
        <!-- Main Statistics -->
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                            <i class="fe-award font-22 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalLeagues }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Total Leagues</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                            <i class="fe-users font-22 avatar-title text-success"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalTeams }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Active Teams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                            <i class="fe-user font-22 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalPlayers }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Total Players</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                            <i class="fe-activity font-22 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $totalMatches }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Total Matches</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row-->

    <div class="row">
        <!-- Match Statistics -->
        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-sm bg-success rounded">
                            <i class="fe-play-circle avatar-title font-22 text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $liveMatches }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Live Matches</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-sm bg-primary rounded">
                            <i class="fe-calendar avatar-title font-22 text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $scheduledMatches }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Scheduled</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-sm bg-info rounded">
                            <i class="fe-flag avatar-title font-22 text-white"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $finishedMatches }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Finished</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <!-- Recent Matches -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Recent Matches</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Match</th>
                            <th>League</th>
                            <th>Score</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentMatches as $match)
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</div>
                                    <small class="text-muted">{{ $match->venue }}</small>
                                </td>
                                <td>{{ $match->league->name }}</td>
                                <td>
                                    @if($match->home_team_score !== null && $match->away_team_score !== null)
                                        <span class="badge badge-light">{{ $match->home_team_score }} - {{ $match->away_team_score }}</span>
                                    @else
                                        <span class="badge badge-warning">No Score</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($match->match_date)->format('M d') }}</td>
                            </tr>
                        @endforeach
                        @if($recentMatches->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No recent matches found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Scorers -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Top Scorers</h4>
                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead>
                        <tr>
                            <th>Player</th>
                            <th>Team</th>
                            <th>Goals</th>
                            <th>Assists</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topScorers as $scorer)
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ $scorer->player->first_name }} {{ $scorer->player->last_name }}</div>
                                    <small class="text-muted">{{ $scorer->player->position }}</small>
                                </td>
                                <td>{{ $scorer->player->team->name }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $scorer->goals }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $scorer->assists }}</span>
                                </td>
                            </tr>
                        @endforeach
                        @if($topScorers->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No player statistics available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <!-- Upcoming Matches -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Upcoming Matches</h4>
                <div class="slimscroll" style="max-height: 400px;">
                    @foreach($upcomingMatches as $match)
                        <div class="border rounded p-3 mb-2">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="font-weight-bold">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</div>
                                    <small class="text-muted">{{ $match->league->name }} • {{ $match->venue }}</small>
                                </div>
                                <div class="col-4 text-right">
                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, H:i') }}</small>
                                    <span class="badge badge-primary">{{ $match->match_week }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($upcomingMatches->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fe-calendar display-4"></i>
                            <p class="mt-2">No upcoming matches scheduled</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- League Standings Overview -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">League Standings Overview</h4>
                <div class="slimscroll" style="max-height: 400px;">
                    @foreach($activeLeagues as $league)
                        <div class="border rounded p-3 mb-3">
                            <h5 class="font-16 mb-2">{{ $league->name }}</h5>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                    <tr>
                                        <th>Team</th>
                                        <th>P</th>
                                        <th>PTS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($league->standings->take(3) as $standing)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold">{{ $standing->team->name }}</div>
                                            </td>
                                            <td>{{ $standing->played }}</td>
                                            <td>
                                                <span class="badge badge-success">{{ $standing->points }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($league->standings->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No standings data</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    @if($activeLeagues->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fe-award display-4"></i>
                            <p class="mt-2">No active leagues</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <!-- Team Status Overview -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Team Status Overview</h4>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="p-2">
                            <i class="fe-check-circle text-success mdi-24px"></i>
                            <h3><span data-plugin="counterup">{{ $teamStatusCounts->has('approved') ? $teamStatusCounts->get('approved')->count : 0 }}</span></h3>
                            <p class="text-muted font-15 mb-0">Approved</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2">
                            <i class="fe-clock text-warning mdi-24px"></i>
                            <h3><span data-plugin="counterup">{{ $teamStatusCounts->has('pending') ? $teamStatusCounts->get('pending')->count : 0 }}</span></h3>
                            <p class="text-muted font-15 mb-0">Pending</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2">
                            <i class="fe-x-circle text-danger mdi-24px"></i>
                            <h3><span data-plugin="counterup">{{ $teamStatusCounts->has('rejected') ? $teamStatusCounts->get('rejected')->count : 0 }}</span></h3>
                            <p class="text-muted font-15 mb-0">Rejected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Quick Actions</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('admin.live.matches') }}" class="btn btn-outline-primary btn-block mb-2">
                            <i class="fe-play-circle mr-1"></i> Live Matches
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.finished.matches') }}" class="btn btn-outline-success btn-block mb-2">
                            <i class="fe-flag mr-1"></i> Finished Matches
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.match') }}" class="btn btn-outline-info btn-block mb-2">
                            <i class="fe-users mr-1"></i> Manage Teams
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.league') }}" class="btn btn-outline-warning btn-block mb-2">
                            <i class="fe-award mr-1"></i> Manage Leagues
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('scripts')
    <script>
        // Initialize counter up plugin
        $(document).ready(function() {
            $('[data-plugin="counterup"]').counterUp({
                delay: 100,
                time: 1200
            });
        });
    </script>
@endsection
