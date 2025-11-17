@extends('layouts.admin')
@section('title', 'Finished Matches')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="header-title">Finished Matches</h4>
                        <p class="text-muted">Manage completed matches and update missing scores</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @if($finishedMatches->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Match</th>
                                        <th>League</th>
                                        <th>Date & Time</th>
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($finishedMatches as $match)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        @if($match->homeTeam->logo !== 'default_team.png')
                                                            <img src="{{ asset('storage/' . $match->homeTeam->logo) }}" alt="{{ $match->homeTeam->name }}" class="rounded-circle" width="30" height="30">
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <strong>{{ $match->homeTeam->name }}</strong> vs
                                                        <strong>{{ $match->awayTeam->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $match->venue }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light">{{ $match->league->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $match->match_week }}</small>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($match->home_team_score !== null && $match->away_team_score !== null)
                                                    <span class="h5 mb-0">
                                                            <strong>{{ $match->home_team_score }}</strong> - <strong>{{ $match->away_team_score }}</strong>
                                                        </span>
                                                @else
                                                    <span class="text-warning">
                                                            <i class="fe-alert-triangle mr-1"></i>Score Missing
                                                        </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-success">Finished</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($match->home_team_score === null || $match->away_team_score === null)
                                                        <button class="btn btn-sm btn-primary" onclick="updateScore({{ $match->id }})" title="Update Score">
                                                            <i class="fe-edit-2 mr-1"></i>Add Score
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-primary" onclick="viewMatchEvents({{ $match->id }})" title="View Events">
                                                            <i class="fe-eye mr-1"></i>View Events
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fe-check-circle display-4 text-muted"></i>
                                <h4 class="text-muted mt-3">No Finished Matches</h4>
                                <p class="text-muted">All finished matches have complete scores.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Score Modal -->
    <div id="updateScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Match Score</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="score_match_id">
                    <div class="form-group text-center">
                        <div class="row">
                            <div class="col-5">
                                <label id="home_team_name" class="font-weight-bold"></label>
                                <input type="number" class="form-control text-center" id="home_score" min="0" value="0">
                            </div>
                            <div class="col-2 text-center pt-4">-</div>
                            <div class="col-5">
                                <label id="away_team_name" class="font-weight-bold"></label>
                                <input type="number" class="form-control text-center" id="away_score" min="0" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveScore()">Update Score</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Match Events Modal -->
    <div id="matchEventsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Match Events</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="eventsLoading" class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading events...</p>
                    </div>
                    <div id="eventsContent" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 id="matchTitle" class="text-center"></h5>
                                <h6 id="matchScore" class="text-center text-muted"></h6>
                            </div>
                        </div>
                        <div id="eventsList" class="events-list" style="max-height: 400px; overflow-y: auto;">
                            <!-- Events will be loaded here -->
                        </div>
                    </div>
                    <div id="noEvents" class="text-center py-4" style="display: none;">
                        <i class="fe-info display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Events Recorded</h5>
                        <p class="text-muted">No match events were recorded for this game.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
