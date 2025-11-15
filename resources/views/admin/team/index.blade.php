@extends('layouts.admin')
@section('title', 'Teams')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-1">

                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Team Name</th>
                            <th>Manager</th>
                            <th>Manager's Email</th>
                            <th>Manager's Phone</th>
                            <th>Payment Reference Number</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Registration Date</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                        </thead>

                        <tbody id="team_table">

                        @foreach($teams as $team)
                            <tr id="team_{{ $team->id }}">
                                <td>{{ $loop->index + 1 }}</td>

                                <td>{{ $team->name }}</td>
                                <td>{{ $team->team_manager }}</td>
                                <td>{{ $team->manager_email }}</td>
                                <td>{{ $team->manager_phone }}</td>
                                <td>{{ $team->payment_reference_number }}</td>

                                <td>
                                    @if($team->team_status == 'pending')
                                        <span class="badge badge-warning font-14">Pending</span>
                                    @elseif($team->team_status == 'approved')
                                        <span class="badge badge-success font-14">Approved</span>
                                    @else
                                        <span class="badge badge-danger font-14">Rejected</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="checkbox checkbox-success mb-2">
                                        <input id="active_{{ $team->id }}" type="checkbox" {{ $team->active == '1' ? 'checked' : '' }} onchange="updateTeamActiveStatus({{ $team->id }});">
                                        <label for="active_{{ $team->id }}">&nbsp;</label>
                                    </div>
                                </td>

                                <td>{{ formatDateTime($team->created_at, 12) }}</td>

                                <td class="text-center">

                                    @if($team->team_status == 'pending')
                                        <button type="button" class="btn btn-blue btn-xs waves-effect waves-light" onclick="changeTeamStatus('{{ $team->id }}', 'approved')">
                                            <i class="mdi mdi-check-all mr-1"></i> Approve
                                        </button>

                                        <button type="button" class="btn btn-xs btn-danger waves-effect waves-light" onclick="changeTeamStatus('{{ $team->id }}', 'rejected')">
                                            <i class="mdi mdi-cancel mr-1"></i> Reject
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-xs btn-primary waves-effect waves-light" onclick="viewTeamPlayer({{ $team->id }})">
                                        <i class="mdi mdi-account-multiple mr-1"></i> View Team Players
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

    <div id="view_team_players_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewTeamPlayersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewTeamPlayersModalLabel">Team Players</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="loadingPlayers">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading players...</p>
                    </div>

                    <div id="teamPlayersContent" style="display: none;">
                        <h5 class="text-center mb-4" id="teamNameTitle"></h5>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Player Name</th>
                                    <th>Position</th>
                                    <th>Jersey No.</th>
                                    <th>Nationality</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody id="teamPlayersTable">
                                <!-- Players will be loaded here dynamically -->
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3" id="noPlayersMessage" style="display: none;">
                            <p class="text-muted">No players found for this team.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
