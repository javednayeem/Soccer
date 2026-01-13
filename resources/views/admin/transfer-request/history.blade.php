@extends('layouts.admin')
@section('title', 'Transfer Requests History')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">

                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th>Player Details</th>
                            <th>Teams</th>
                            <th>Request Details</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transfer_requests as $request)
                            @php
                                $player = $request->player;
                                $fromTeam = $request->fromTeam;
                                $toTeam = $request->toTeam;
                            @endphp
                            <tr id="player_transfer_{{ $request->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <img src="{{ asset($player->photo) }}" alt="{{ $player->first_name }}" class="img-fluid rounded-circle" width="50" onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 font-size-14">{{ $player->first_name }} {{ $player->last_name }}</h6>
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
                                            <small class="d-block">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                Requested: {{ $request->created_at->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>

                                    @if($request->transfer_status == 'approved')
                                        <span class="badge badge-success badge-pill py-1 px-3">
                                            <i class="fas fa-check mr-1"></i> Approved
                                        </span>

                                        <div class="mt-2 small">
                                            Approved At: {{ formatDate($request->approved_at) }}
                                        </div>

                                        <div class="mt-2 small">
                                            Approved By: {{ $request->modifier->name }}
                                        </div>

                                    @else
                                        <span class="badge badge-danger badge-pill py-1 px-3">
                                            <i class="fas fa-times mr-1"></i> Rejected
                                        </span>

                                        <div class="mt-2 small">
                                            Rejected At: {{ formatDate($request->approved_at) }}
                                        </div>

                                        <div class="mt-2 small">
                                            Rejected By: {{ $request->modifier->name }}
                                        </div>

                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                        <h4 class="text-muted">No Transfer Requests</h4>
                                        <p class="text-muted">There are no approved or rejected requests at the moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
