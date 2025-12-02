@extends('layouts.admin')
@section('title', 'Teams')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">

                <div class="row">
                    <div class="col-md-10">

                    </div>

                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="button" class="btn btn-dark waves-effect waves-light m-b-30" data-toggle="modal" data-target="#add_team_modal">
                                <i class="md md-add"></i> Add New Team
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table table-hover table-striped table-bordered" id="teamsTable">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Team Info</th>
                            <th>Manager Info</th>
                            <th>Payment & Status</th>
                            <th>Registration</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody id="team_table">
                        @foreach($teams as $team)
                            <tr id="team_{{ $team->id }}">
                                <td class="text-center">
                                    <span class="fw-bold text-muted">{{ $loop->index + 1 }}</span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($team->logo && $team->logo != 'default_team.png')
                                                <img src="{{ asset('site/images/teams/' . $team->logo) }}"
                                                     alt="{{ $team->name }}"
                                                     class="rounded-circle me-3"
                                                     width="40" height="40"
                                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                            @else
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="mdi mdi-account-group text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold text-primary ml-2">{{ $team->name }}</h6>
                                            @if($team->short_name)
                                                <small class="text-muted">({{ $team->short_name }})</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="manager-info">
                                        <div class="fw-semibold text-dark">{{ $team->team_manager }}</div>
                                        @if($team->manager_email)
                                            <div class="small text-primary">
                                                <i class="mdi mdi-email-outline me-1"></i>
                                                <a href="mailto:{{ $team->manager_email }}" class="text-decoration-none">{{ $team->manager_email }}</a>
                                            </div>
                                        @endif
                                        @if($team->manager_phone)
                                            <div class="small text-success">
                                                <i class="mdi mdi-phone-outline me-1"></i>
                                                <a href="tel:{{ $team->manager_phone }}" class="text-decoration-none">{{ $team->manager_phone }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        @if($team->payment_reference_number)
                                            <span class="badge badge-info font-14 mb-2">
                                        <i class="mdi mdi-receipt me-1"></i>
                                        {{ $team->payment_reference_number }}
                                    </span>
                                        @endif

                                        <div class="status-section">
                                    <span class="badge
                                        @if($team->team_status == 'pending') badge-warning
                                        @elseif($team->team_status == 'approved') badge-success
                                        @elseif($team->team_status == 'rejected') badge-danger
                                        @else badge-secondary @endif font-14 me-2">
                                        {{ ucfirst($team->team_status) }}
                                    </span>

                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox"
                                                       id="active_{{ $team->id }}"
                                                       {{ $team->active == '1' ? 'checked' : '' }}
                                                       onchange="updateTeamActiveStatus({{ $team->id }});">
                                                <label class="form-check-label small" for="active_{{ $team->id }}">
                                                    {{ $team->active == '1' ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-center">
                                        <div class="fw-semibold text-dark small">
                                            {{ \Carbon\Carbon::parse($team->created_at)->format('M d, Y') }}
                                        </div>
                                        <div class="text-muted smaller">
                                            {{ \Carbon\Carbon::parse($team->created_at)->format('h:i A') }}
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Edit Button -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary waves-effect waves-light"
                                                onclick="editTeam(this)"
                                                data-id="{{ $team->id }}"
                                                data-name="{{ $team->name }}"
                                                data-short-name="{{ $team->short_name }}"
                                                data-team-manager="{{ $team->team_manager }}"
                                                data-manager-email="{{ $team->manager_email }}"
                                                data-manager-phone="{{ $team->manager_phone }}"
                                                data-note="{{ $team->note }}"
                                                data-payment-reference-number="{{ $team->payment_reference_number }}"
                                                data-team-status="{{ $team->team_status }}"
                                                data-logo="{{ asset('site/images/teams/' . $team->logo) }}"
                                                data-team-image="{{ asset('site/images/teams/' . $team->team_image) }}"
                                                title="Edit Team">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </button>

                                        <!-- View Players Button -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info waves-effect waves-light"
                                                onclick="viewTeamPlayer({{ $team->id }})"
                                                title="View Players">
                                            <i class="mdi mdi-account-multiple-outline"></i>
                                        </button>

                                        <!-- Status Buttons -->
                                        @if($team->team_status == 'pending')
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success waves-effect waves-light"
                                                    onclick="changeTeamStatus('{{ $team->id }}', 'approved')"
                                                    title="Approve Team">
                                                <i class="mdi mdi-check"></i>
                                            </button>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    onclick="changeTeamStatus('{{ $team->id }}', 'rejected')"
                                                    title="Reject Team">
                                                <i class="mdi mdi-close"></i>
                                            </button>
                                    @endif

                                    <!-- Delete Button -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                onclick="deleteTeam({{ $team->id }})"
                                                title="Delete Team">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </button>
                                    </div>

                                    <!-- Quick Actions Dropdown for Mobile -->
                                    <div class="dropdown d-inline-block d-md-none">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="editTeam(this.parentElement.parentElement.parentElement.querySelector('.btn-outline-primary'))"><i class="mdi mdi-pencil-outline me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="viewTeamPlayer({{ $team->id }})"><i class="mdi mdi-account-multiple-outline me-2"></i>View Players</a></li>
                                            @if($team->team_status == 'pending')
                                                <li><a class="dropdown-item text-success" href="#" onclick="changeTeamStatus('{{ $team->id }}', 'approved')"><i class="mdi mdi-check me-2"></i>Approve</a></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="changeTeamStatus('{{ $team->id }}', 'rejected')"><i class="mdi mdi-close me-2"></i>Reject</a></li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteTeam({{ $team->id }})"><i class="mdi mdi-delete-outline me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div id="add_team_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Team</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Team Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="short_name" class="control-label">Short Name</label>
                                <input type="text" class="form-control" id="short_name" autocomplete="off" placeholder="e.g., FCB">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_manager" class="control-label">Team Manager <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="team_manager" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="manager_email" class="control-label">Manager Email</label>
                                <input type="email" class="form-control" id="manager_email" autocomplete="off" placeholder="manager@example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="manager_phone" class="control-label">Manager Phone</label>
                                <input type="text" class="form-control" id="manager_phone" autocomplete="off" placeholder="+358123456789">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_reference_number" class="control-label">Payment Reference</label>
                                <input type="text" class="form-control" id="payment_reference_number" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_status" class="control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="team_status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo" class="control-label">Team Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="viewSelectedImage(this, 'add_team_logo');">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_image" class="control-label">Team Image</label>
                                <input type="file" class="form-control" id="team_image" name="team_image" accept="image/*" onchange="viewSelectedImage(this, 'add_team_image_preview');">
                            </div>
                        </div>

                        <div class="col-md-6 text-center">
                            <img id="add_team_logo" src="{{ asset('site/images/teams/default_team.png') }}" alt="Team Logo" class="img-fluid rounded" style="max-height: 150px" onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}'">
                            <p class="small text-muted mt-1">Team Logo</p>
                        </div>

                        <div class="col-md-6 text-center">
                            <img id="add_team_image_preview" src="{{ asset('site/images/teams/default_team.png') }}" alt="Team Image" class="img-fluid rounded" style="max-height: 150px" onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team_image.png') }}'">
                            <p class="small text-muted mt-1">Team Image</p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="control-label">Note</label>
                                <textarea class="form-control" id="note" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="add_team_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_team_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Team</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="team_id" value="0">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name" class="control-label">Team Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_short_name" class="control-label">Short Name</label>
                                <input type="text" class="form-control" id="edit_short_name" autocomplete="off" placeholder="e.g., FCB">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_team_manager" class="control-label">Team Manager <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_team_manager" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_manager_email" class="control-label">Manager Email</label>
                                <input type="email" class="form-control" id="edit_manager_email" autocomplete="off" placeholder="manager@example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_manager_phone" class="control-label">Manager Phone</label>
                                <input type="text" class="form-control" id="edit_manager_phone" autocomplete="off" placeholder="+358123456789">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_payment_reference_number" class="control-label">Payment Reference</label>
                                <input type="text" class="form-control" id="edit_payment_reference_number" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_team_status" class="control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_team_status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_logo" class="control-label">Team Logo</label>
                                <input type="file" class="form-control" id="edit_logo" name="edit_logo" accept="image/*" onchange="viewSelectedImage(this, 'edit_team_logo');">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_team_image" class="control-label">Team Image</label>
                                <input type="file" class="form-control" id="edit_team_image" name="edit_team_image" accept="image/*" onchange="viewSelectedImage(this, 'edit_team_image_preview');">
                            </div>
                        </div>

                        <div class="col-md-6 text-center">
                            <img id="edit_team_logo" src="{{ asset('site/images/teams/default_team.png') }}" alt="Team Logo" class="img-fluid rounded" style="max-height: 150px" onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}'">
                            <p class="small text-muted mt-1">Team Logo</p>
                        </div>

                        <div class="col-md-6 text-center">
                            <img id="edit_team_image_preview" src="{{ asset('site/images/teams/default_team.png') }}" alt="Team Image" class="img-fluid rounded" style="max-height: 150px" onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team_image.png') }}'">
                            <p class="small text-muted mt-1">Team Image</p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_note" class="control-label">Note</label>
                                <textarea class="form-control" id="edit_note" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="edit_team_button">Save</button>
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