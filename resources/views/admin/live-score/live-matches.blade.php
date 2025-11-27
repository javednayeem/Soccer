@extends('layouts.admin')
@section('title', 'Live Matches')

@section('content')

    <input type="hidden" id="live_matches_json" value='@json($liveMatches)'>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        @if($liveMatches->count() > 0)
                            @foreach($liveMatches as $match)
                                <div class="card mb-3 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 class="card-title mb-0 text-white">
                                                    {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                                </h5>
                                                <small class="text-white-50">{{ $match->league->name }} - {{ $match->match_week }}</small>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <span class="badge badge-light">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y H:i') }}</span>
                                                <span class="badge badge-success ml-1">LIVE</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Match Score -->
                                            <div class="col-md-4 text-center">
                                                <div class="match-score">
                                                    <h2 class="text-primary mb-0">
                                                        <span id="home_score_{{ $match->id }}">{{ $match->home_team_score ?? 0 }}</span>
                                                        -
                                                        <span id="away_score_{{ $match->id }}">{{ $match->away_team_score ?? 0 }}</span>
                                                    </h2>
                                                    <small class="text-muted">Current Score</small>

                                                    <div class="mt-3">
                                                        <button class="btn btn-sm btn-primary" onclick="updateScore({{ $match->id }})">
                                                            <i class="fe-edit mr-1"></i> Update Score
                                                        </button>
                                                        <button class="btn btn-sm btn-success" onclick="finishMatch({{ $match->id }})">
                                                            <i class="fe-flag mr-1"></i> Finish Match
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Match Events -->
                                            <div class="col-md-5">
                                                <h6>Match Events</h6>
                                                <div id="events_list_{{ $match->id }}" class="events-list" style="max-height: 200px; overflow-y: auto;">
                                                    @foreach($match->events as $event)
                                                        <div class="event-item mb-2 p-2 border rounded">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                            <span class="badge
                                                                @if($event->type == 'goal') badge-success
                                                                @elseif($event->type == 'yellow_card') badge-warning
                                                                @elseif($event->type == 'red_card') badge-danger
                                                                @else badge-info @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                                                            </span>
                                                                    <strong>{{ $event->player->first_name }} {{ $event->player->last_name }}</strong>
                                                                    <small class="text-muted">({{ $event->minute }}')</small>
                                                                </div>
                                                                <button class="btn btn-xs btn-danger" onclick="deleteEvent({{ $match->id }}, {{ $event->id }})">
                                                                    <i class="fe-trash-2"></i>
                                                                </button>
                                                            </div>
                                                            @if($event->description)
                                                                <small class="text-muted d-block mt-1">{{ $event->description }}</small>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <button class="btn btn-sm btn-outline-primary mt-2" onclick="addEvent({{ $match->id }})">
                                                    <i class="fe-plus mr-1"></i> Add Event
                                                </button>
                                            </div>

                                            <!-- Quick Actions -->
                                            <div class="col-md-3">
                                                <h6>Quick Actions</h6>
                                                <div class="list-group">
                                                    <button class="list-group-item list-group-item-action" onclick="quickGoal({{ $match->id }}, {{ $match->home_team_id }})">
                                                        <i class="fe-target mr-1 text-success"></i> Home Goal
                                                    </button>
                                                    <button class="list-group-item list-group-item-action" onclick="quickGoal({{ $match->id }}, {{ $match->away_team_id }})">
                                                        <i class="fe-target mr-1 text-success"></i> Away Goal
                                                    </button>
                                                    <button class="list-group-item list-group-item-action" onclick="addEvent({{ $match->id }})">
                                                        <i class="fe-alert-triangle mr-1 text-warning"></i> Yellow Card
                                                    </button>
                                                    <button class="list-group-item list-group-item-action" onclick="addEvent({{ $match->id }})">
                                                        <i class="fe-alert-octagon mr-1 text-danger"></i> Red Card
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fe-clock display-4 text-muted"></i>
                                <h4 class="text-muted mt-3">No Live Matches</h4>
                                <p class="text-muted">There are currently no live matches to manage.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updateScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Match Score</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="score_match_id">

                    <!-- Loading State -->
                    <div id="score_loading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading match details...</p>
                    </div>

                    <!-- Content -->
                    <div id="score_content" style="display: none;">
                        <!-- Score Section -->
                        <div class="score-section mb-4">
                            <h6 class="text-center mb-3 text-muted">Final Score</h6>
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <label id="home_team_name" class="font-weight-bold d-block text-center mb-2"></label>
                                        <input type="number" class="form-control text-center font-weight-bold"
                                               id="home_score" min="0" value="0" style="font-size: 1.2rem;">
                                    </div>
                                    <div class="col-2 text-center">
                                        <span class="h4 text-muted">-</span>
                                    </div>
                                    <div class="col-5">
                                        <label id="away_team_name" class="font-weight-bold d-block text-center mb-2"></label>
                                        <input type="number" class="form-control text-center font-weight-bold"
                                               id="away_score" min="0" value="0" style="font-size: 1.2rem;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Man of the Match Section -->
                        <div id="motm_section" class="motm-section border-top pt-3">
                            <h6 class="text-center mb-3 text-muted">
                                <i class="mdi mdi-trophy-outline text-warning mr-2"></i>
                                Man of the Match
                            </h6>
                            <div class="form-group">
                                <select class="form-control" id="man_of_the_match">
                                    <option value="">Select Man of the Match</option>
                                    <!-- Players will be loaded via AJAX -->
                                </select>
                                <small class="form-text text-muted">
                                    Select the outstanding player from either team (optional)
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveScore()">
                        <i class="mdi mdi-content-save mr-1"></i>
                        Update Score
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="addEventModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Match Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_match_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Team</label>
                                <select class="form-control" id="event_team_id">
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Player</label>
                                <select class="form-control" id="event_player_id">
                                    <option value="">Select Player</option>
                                    <!-- Players will be loaded via AJAX -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Type</label>
                                <select class="form-control" id="event_type">
                                    <option value="goal">Goal</option>
                                    <option value="assist">Assist</option>
                                    <option value="yellow_card">Yellow Card</option>
                                    <option value="red_card">Red Card</option>
                                    <option value="substitution_in">Substitution In</option>
                                    <option value="substitution_out">Substitution Out</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minute</label>
                                <input type="number" class="form-control" id="event_minute" min="1" max="120" placeholder="Minute">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description (Optional)</label>
                                <textarea class="form-control" id="event_description" placeholder="Event description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEvent()">Add Event</button>
                </div>
            </div>
        </div>
    </div>

@endsection