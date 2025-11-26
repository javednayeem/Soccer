@extends('layouts.admin')
@section('title', "Player")

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-10">
                                <form id="searchPlayer" class="form-inline" role="form" action="{{ route('admin.search.player') }}" method="post">
                                    @csrf

                                    <div class="form-group mr-2">
                                        <input type="text" class="form-control" name="player_name" id="player_name"
                                               placeholder="Search player name" value="{{ isset($search_player_name) ? $search_player_name : '' }}">
                                    </div>

                                    <div class="form-group mr-2">
                                        <select class="form-control" id="team_id" name="team_id">
                                            <option value="all">All Teams</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}" {{ (isset($search_team_id) ? $search_team_id : '') == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mr-2">
                                        <select class="form-control" id="player_status" name="player_status">
                                            <option value="">All Status</option>
                                            <option value="1" {{ (isset($search_player_status) ? $search_player_status : '') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (isset($search_player_status) ? $search_player_status : '') == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fa fa-search"></i> Search
                                    </button>

                                    <a href="{{ route('admin.player') }}?clear_session=1" class="btn btn-secondary">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </form>
                            </div>

                            <div class="col-md-2">
                                <div class="text-right">
                                    <button type="button" class="btn btn-dark waves-effect waves-light m-b-30" data-toggle="modal" data-target="#add_player_modal">
                                        <i class="md md-add"></i> Add New Player
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover mt-3">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Player Name</th>
                                    <th>Team</th>
                                    <th>Position</th>
                                    <th>Jersey No.</th>
                                    <th>Nationality</th>
                                    <th>Date of Birth</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody id="player_table">
                                @foreach($players as $player)
                                    <tr id="player_{{ $player->id }}">
                                        <td>{{ ($players->currentPage() - 1) * $players->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($player->photo) }}" alt="{{ $player->first_name }}" class="rounded-circle mr-2" width="40" height="40" onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                                                <div>
                                                    {{ $player->first_name }} {{ $player->last_name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ isset($player->team->name) ? $player->team->name : 'N/A' }}</td>
                                        <td>{{ ucfirst($player->position) }}</td>
                                        <td>{{ isset($player->jersey_number) ? $player->jersey_number : 'N/A' }}</td>
                                        <td>{{ $player->nationality }}</td>
                                        <td>{{ \Carbon\Carbon::parse($player->date_of_birth)->format('M d, Y') }}</td>
                                        <td>
                                            @if($player->player_status == '1')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-primary"
                                                    onclick="editPlayer(this)"
                                                    data-id="{{ $player->id }}"
                                                    data-team-id="{{ $player->team_id }}"
                                                    data-first-name="{{ $player->first_name }}"
                                                    data-last-name="{{ $player->last_name }}"
                                                    data-phone-no="{{ $player->phone_no }}"
                                                    data-email="{{ $player->email }}"
                                                    data-nationality="{{ $player->nationality }}"
                                                    data-position="{{ $player->position }}"
                                                    data-jersey-number="{{ $player->jersey_number }}"
                                                    data-height="{{ $player->height }}"
                                                    data-weight="{{ $player->weight }}"
                                                    data-date-of-birth="{{ date('Y-m-d', strtotime($player->date_of_birth)) }}"
                                                    data-player-status="{{ $player->player_status }}"
                                                    data-photo="{{ $player->photo }}"
                                                    title="Edit Player">
                                                <i class="fe-edit"></i>
                                            </button>

                                            <button class="btn btn-xs btn-icon waves-effect waves-light btn-danger" onclick="deletePlayer({{ $player->id }})">
                                                <i class="fe-trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                {{ $players->links('pagination::bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="add_player_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Player</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="control-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_team_id" class="control-label">Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="create_team_id">
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        @if($team->team_status == 'approved')
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nationality" class="control-label">Nationality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nationality" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_no" class="control-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone_no" autocomplete="off" placeholder="+358123456789">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" autocomplete="off" placeholder="player@example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position" class="control-label">Position <span class="text-danger">*</span></label>
                                <select class="form-control" id="position">
                                    <option value="">Select Position</option>
                                    <option value="Goalkeeper">Goalkeeper</option>
                                    <option value="Defender">Defender</option>
                                    <option value="Midfielder">Midfielder</option>
                                    <option value="Forward">Forward</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jersey_number" class="control-label">Jersey Number</label>
                                <input type="number" class="form-control" id="jersey_number" min="1" max="99" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="height" class="control-label">Height (meters)</label>
                                <input type="number" step="0.01" class="form-control" id="height" min="1.50" max="2.20" placeholder="1.75">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight" class="control-label">Weight (kg)</label>
                                <input type="number" step="0.1" class="form-control" id="weight" min="40" max="120" placeholder="70.5">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth" class="control-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_of_birth">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo" class="control-label">Player Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="viewSelectedImage(this, 'add_player_photo');">
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <img id="add_player_photo" src="/site/images/players/default_player.jpg" alt="Player Photo" class="img-fluid rounded" style="max-height: 200px" onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="add_player_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_player_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Player</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="player_id" value="0">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_first_name" class="control-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_first_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_last_name" class="control-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_last_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_team_id" class="control-label">Team <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_team_id">
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nationality" class="control-label">Nationality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nationality" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_phone_no" class="control-label">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone_no" autocomplete="off" placeholder="+358123456789">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" autocomplete="off" placeholder="player@example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_position" class="control-label">Position <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_position">
                                    <option value="">Select Position</option>
                                    <option value="Goalkeeper">Goalkeeper</option>
                                    <option value="Defender">Defender</option>
                                    <option value="Midfielder">Midfielder</option>
                                    <option value="Forward">Forward</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_jersey_number" class="control-label">Jersey Number</label>
                                <input type="number" class="form-control" id="edit_jersey_number" min="1" max="99" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_height" class="control-label">Height (meters)</label>
                                <input type="number" step="0.01" class="form-control" id="edit_height" min="1.50" max="2.20" placeholder="1.75">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_weight" class="control-label">Weight (kg)</label>
                                <input type="number" step="0.1" class="form-control" id="edit_weight" min="40" max="120" placeholder="70.5">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_date_of_birth" class="control-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_date_of_birth">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_player_status" class="control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_player_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_photo" class="control-label">Player Photo</label>
                                <input type="file" class="form-control" id="edit_photo" name="edit_photo" accept="image/*" onchange="viewSelectedImage(this, 'edit_player_photo');">
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <img id="edit_player_photo" src="/site/images/players/default_player.jpg" alt="Player Photo" class="img-fluid rounded" style="max-height: 200px" onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="edit_player_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
