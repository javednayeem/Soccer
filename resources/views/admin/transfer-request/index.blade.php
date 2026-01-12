@extends('layouts.admin')
@section('title', 'Transfer Requests Management')

@section('content')

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pending Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingCount ?? '' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Approved Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $approvedCount ?? '' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rejected Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $rejectedCount ?? '' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCount ?? '' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search by player name, team, or notes...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="searchButton">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshTable()" title="Refresh">
                                    <i class="fas fa-redo"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="exportTable()" title="Export">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Requests Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th>Player Details</th>
                                <th>Teams</th>
                                <th>Request Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transfer_requests as $request)
                                @php
                                    $player = $request->player;
                                    $fromTeam = $request->fromTeam;
                                    $toTeam = $request->toTeam;
                                @endphp
                                <tr id="transfer-row-{{ $request->id }}">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input transfer-checkbox" id="transfer-{{ $request->id }}" value="{{ $request->id }}">
                                            <label class="custom-control-label" for="transfer-{{ $request->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <img src="{{ asset($player->photo) }}"
                                                     alt="{{ $player->first_name }}"
                                                     class="img-fluid rounded-circle"
                                                     width="50"
                                                     onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                                            </div>
                                            <div>
                                                <h6 class="mb-1 font-size-14">
                                                    {{ $player->first_name }} {{ $player->last_name }}
                                                </h6>
                                                <p class="mb-0 text-muted">
                                                    <small>
                                                        <i class="fas fa-tag mr-1"></i>{{ $player->position }}
                                                        @if($player->jersey_number)
                                                            <span class="mx-2">|</span>
                                                            <i class="fas fa-hashtag mr-1"></i>{{ $player->jersey_number }}
                                                        @endif
                                                    </small>
                                                </p>
                                                <p class="mb-0 text-muted">
                                                    <small>
                                                        <i class="fas fa-envelope mr-1"></i>{{ $player->email ?: 'No email' }}
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="team-transfer-info">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="team-badge from-team">
                                                    <div class="team-logo mr-2">
                                                        <img src="{{ asset('site/images/teams/' . $fromTeam->logo) }}"
                                                             alt="{{ $fromTeam->name }}"
                                                             width="24"
                                                             onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                    </div>
                                                    <div class="team-info">
                                                        <div class="team-name font-weight-bold">{{ $fromTeam->name }}</div>
                                                        <small class="text-muted">Current Team</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="transfer-arrow text-center my-1">
                                                <i class="fas fa-long-arrow-alt-down text-primary"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="team-badge to-team">
                                                    <div class="team-logo mr-2">
                                                        <img src="{{ asset('site/images/teams/' . $toTeam->logo) }}"
                                                             alt="{{ $toTeam->name }}"
                                                             width="24"
                                                             onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                    </div>
                                                    <div class="team-info">
                                                        <div class="team-name font-weight-bold">{{ $toTeam->name }}</div>
                                                        <small class="text-muted">Destination Team</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="request-details">
                                            @if($request->transfer_notes)
                                                <div class="notes mb-2">
                                                    <strong>Notes:</strong>
                                                    <p class="mb-1 text-muted small">{{ Str::limit($request->transfer_notes, 100) }}</p>
                                                    @if(strlen($request->transfer_notes) > 100)
                                                        <a href="javascript:void(0);"
                                                           class="view-notes text-primary small"
                                                           data-notes="{{ $request->transfer_notes }}"
                                                           data-player="{{ $player->first_name }} {{ $player->last_name }}">
                                                            View full notes
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="request-meta">
                                                <small class="text-muted d-block">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    Requested: {{ $request->created_at->format('M d, Y h:i A') }}
                                                </small>
                                                @if($request->updated_at->gt($request->created_at))
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-history mr-1"></i>
                                                        Updated: {{ $request->updated_at->format('M d, Y h:i A') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($request->transfer_status == 'pending')
                                            <span class="badge badge-warning badge-pill py-1 px-3">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            <div class="mt-2 small text-muted">
                                                {{ $request->created_at->diffForHumans() }}
                                            </div>
                                        @elseif($request->transfer_status == 'approved')
                                            <span class="badge badge-success badge-pill py-1 px-3">
                                                    <i class="fas fa-check mr-1"></i> Approved
                                                </span>
                                            @if($request->approved_at)
                                                <div class="mt-2 small text-muted">
                                                    Approved: {{ $request->approved_at->format('M d, Y') }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="badge badge-danger badge-pill py-1 px-3">
                                                    <i class="fas fa-times mr-1"></i> Rejected
                                                </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->transfer_status == 'pending')
                                            <div class="btn-group" role="group">
                                                <button type="button"
                                                        class="btn btn-sm btn-success"
                                                        onclick="processTransfer({{ $request->id }}, 'approved')"
                                                        title="Approve Transfer">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="showRejectModal({{ $request->id }})"
                                                        title="Reject Transfer">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-info"
                                                        onclick="viewTransferDetails({{ $request->id }})"
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        @else
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    onclick="viewTransferDetails({{ $request->id }})"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                            <h4 class="text-muted">No Transfer Requests</h4>
                                            <p class="text-muted">There are no {{ request('status', 'pending') }} transfer requests at the moment.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Actions (for multiple selections) -->
                    <div class="row mt-3" id="bulkActions" style="display: none;">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="font-weight-bold" id="selectedCount">0</span> transfer requests selected
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success" onclick="bulkApprove()">
                                                <i class="fas fa-check mr-1"></i> Approve Selected
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="bulkReject()">
                                                <i class="fas fa-times mr-1"></i> Reject Selected
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="clearSelection()">
                                                <i class="fas fa-times mr-1"></i> Clear Selection
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
