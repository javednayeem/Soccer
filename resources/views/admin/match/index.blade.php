@extends('layouts.admin')
@section('title', 'Matches')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right mb-3">

                            <button type="button" class="btn btn-warning waves-effect waves-light" onclick="calculatePlayerStatistics();">
                                <i class="mdi mdi-calculator"></i> Calculate Player Statistics
                            </button>

                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="calculatePTS();">
                                <i class="mdi mdi-calculator"></i> Calculate PTS
                            </button>

                            <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#add_match_modal">
                                <i class="mdi mdi-swim mr-1"></i> Add New Match
                            </button>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>League</th>
                                    <th>Home Team</th>
                                    <th>Away Team</th>
                                    <th>Match Date & Time</th>
                                    <th>Venue</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th>Match Week</th>
                                    <th style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody id="match_table">
                                @foreach($matches as $match)
                                    <tr id="match_{{ $match->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $match->league->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($match->homeTeam->logo) }}" alt="{{ $match->homeTeam->name }}"
                                                     class="rounded-circle mr-2" width="30" height="30"
                                                     onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                <span>{{ $match->homeTeam->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($match->awayTeam->logo) }}" alt="{{ $match->awayTeam->name }}"
                                                     class="rounded-circle mr-2" width="30" height="30"
                                                     onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                <span>{{ $match->awayTeam->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y H:i') }}</td>
                                        <td>{{ $match->venue }}</td>
                                        <td>
                                            @if($match->status === 'finished' && !is_null($match->home_team_score) && !is_null($match->away_team_score))
                                                <strong>{{ $match->home_team_score }} - {{ $match->away_team_score }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($match->status)
                                            @case('scheduled')
                                            <span class="badge badge-primary">Scheduled</span>
                                            @break
                                            @case('live')
                                            <span class="badge badge-success">Live</span>
                                            @break
                                            @case('finished')
                                            <span class="badge badge-secondary">Finished</span>
                                            @break
                                            @case('postponed')
                                            <span class="badge badge-warning">Postponed</span>
                                            @break
                                            @case('cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                            @break
                                            @endswitch
                                        </td>
                                        <td>{{ $match->match_week ?? 'N/A' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-primary"
                                                    onclick="editMatch(this)"
                                                    data-id="{{ $match->id }}"
                                                    data-league-id="{{ $match->league_id }}"
                                                    data-home-team-id="{{ $match->home_team_id }}"
                                                    data-away-team-id="{{ $match->away_team_id }}"
                                                    data-match-date="{{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }}"
                                                    data-match-time="{{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}"
                                                    data-venue="{{ $match->venue }}"
                                                    data-status="{{ $match->status }}"
                                                    data-home-team-score="{{ $match->home_team_score }}"
                                                    data-away-team-score="{{ $match->away_team_score }}"
                                                    data-match-week="{{ $match->match_week }}"
                                                    title="Edit Match">
                                                <i class="fe-edit"></i>
                                            </button>

                                            <button class="btn btn-xs btn-icon waves-effect waves-light btn-danger" onclick="deleteMatch({{ $match->id }})">
                                                <i class="fe-trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="add_match_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Match</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="league_id" class="control-label">League <span class="text-danger">*</span></label>
                                <select class="form-control" id="league_id">
                                    <option value="">Select League</option>
                                    @foreach($leagues as $league)
                                        <option value="{{ $league->id }}">{{ $league->name }} ({{ $league->season }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="match_week" class="control-label">Match Week</label>
                                <input type="text" class="form-control" id="match_week" placeholder="e.g., Week 1, Round of 16">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_team_id" class="control-label">Home Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="home_team_id">
                                    <option value="">Select Home Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="away_team_id" class="control-label">Away Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="away_team_id">
                                    <option value="">Select Away Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="match_date" class="control-label">Match Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="match_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="match_time" class="control-label">Match Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="match_time">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="venue" class="control-label">Venue <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="venue" placeholder="Enter venue name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="live">Live</option>
                                    <option value="finished">Finished</option>
                                    <option value="postponed">Postponed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="home_team_score" class="control-label">Home Score</label>
                                <input type="number" class="form-control" id="home_team_score" min="0" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="away_team_score" class="control-label">Away Score</label>
                                <input type="number" class="form-control" id="away_team_score" min="0" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="add_match_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_match_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Match</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="match_id" value="0">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_league_id" class="control-label">League <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_league_id">
                                    <option value="">Select League</option>
                                    @foreach($leagues as $league)
                                        <option value="{{ $league->id }}">{{ $league->name }} ({{ $league->season }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_match_week" class="control-label">Match Week</label>
                                <input type="text" class="form-control" id="edit_match_week" placeholder="e.g., Week 1, Round of 16">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_home_team_id" class="control-label">Home Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_home_team_id">
                                    <option value="">Select Home Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_away_team_id" class="control-label">Away Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_away_team_id">
                                    <option value="">Select Away Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_match_date" class="control-label">Match Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_match_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_match_time" class="control-label">Match Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="edit_match_time">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_venue" class="control-label">Venue <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_venue" placeholder="Enter venue name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_status" class="control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="live">Live</option>
                                    <option value="finished">Finished</option>
                                    <option value="postponed">Postponed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_home_team_score" class="control-label">Home Score</label>
                                <input type="number" class="form-control" id="edit_home_team_score" min="0" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_away_team_score" class="control-label">Away Score</label>
                                <input type="number" class="form-control" id="edit_away_team_score" min="0" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="edit_match_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
