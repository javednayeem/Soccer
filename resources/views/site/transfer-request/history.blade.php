@extends('layouts.site')
@section('title', 'Transfer Request History')
@section('subtitle', 'View all your team transfer requests')

@section('content')

    <div class="transfer-history-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-history me-2"></i>Transfer Request History
                            </h4>
                        </div>

                        <div class="card-body p-4">

                            @if($transfer_requests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Player Details</th>
                                            <th>Transfer Details</th>
                                            <th>Request Date</th>
                                            <th>Status</th>
                                            <th>Approval Info</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transfer_requests as $request)
                                            @php
                                                $player = $request->player;
                                                $fromTeam = $request->fromTeam;
                                                $toTeam = $request->toTeam;
                                                $statusClass = $request->transfer_status == 'approved' ? 'success' : ($request->transfer_status == 'pending' ? 'warning' : 'danger');
                                                $statusIcon = $request->transfer_status == 'approved' ? 'check-circle' : ($request->transfer_status == 'pending' ? 'clock' : 'times-circle');
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <img src="{{ asset($player->photo) }}" 
                                                                 alt="{{ $player->first_name }}" 
                                                                 class="rounded-circle" 
                                                                 width="50" 
                                                                 height="50"
                                                                 style="object-fit: cover;"
                                                                 onerror="this.onerror=null; this.src='/site/images/players/default_player.jpg'">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">{{ $player->first_name }} {{ $player->last_name }}</h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-tag me-1"></i>{{ $player->position }}
                                                                @if($player->jersey_number)
                                                                    <span class="mx-2">|</span>
                                                                    <i class="fas fa-hashtag me-1"></i>{{ $player->jersey_number }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="transfer-flow">
                                                        <!-- From Team -->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <img src="{{ asset('site/images/teams/' . $fromTeam->logo) }}"
                                                                 alt="{{ $fromTeam->name }}"
                                                                 width="30"
                                                                 height="30"
                                                                 class="me-2"
                                                                 style="object-fit: contain;"
                                                                 onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                            <div>
                                                                <div class="fw-semibold"><a href="{{ url('/team/' . $fromTeam->id . '/players') }}" class="text-dark fw-bold text-decoration-none">{{ $fromTeam->name }}</a></div>
                                                                <small class="text-muted">From</small>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Arrow -->
                                                        <div class="text-center my-1">
                                                            <i class="fas fa-arrow-down text-primary"></i>
                                                        </div>
                                                        
                                                        <!-- To Team -->
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('site/images/teams/' . $toTeam->logo) }}"
                                                                 alt="{{ $toTeam->name }}"
                                                                 width="30"
                                                                 height="30"
                                                                 class="me-2"
                                                                 style="object-fit: contain;"
                                                                 onerror="this.onerror=null; this.src='/site/images/teams/default_team.png'">
                                                            <div>
                                                                <div class="fw-semibold"><a href="{{ url('/team/' . $toTeam->id . '/players') }}" class="text-dark fw-bold text-decoration-none">{{ $toTeam->name }}</a></div>
                                                                <small class="text-muted">To</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($request->transfer_notes)
                                                        <div class="mt-3">
                                                            <small class="text-muted">
                                                                <i class="fas fa-sticky-note me-1"></i>
                                                                <strong>Notes:</strong><br>
                                                                {{ Str::limit($request->transfer_notes, 80) }}
                                                                @if(strlen($request->transfer_notes) > 80)
                                                                    <a href="#" 
                                                                       class="text-primary" 
                                                                       data-bs-toggle="modal" 
                                                                       data-bs-target="#notesModal{{ $request->id }}">
                                                                        Read more
                                                                    </a>
                                                                @endif
                                                            </small>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        {{ $request->created_at->format('M d, Y') }}<br>
                                                        <i class="far fa-clock me-1"></i>
                                                        {{ $request->created_at->format('h:i A') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $statusClass }} text-white px-3 py-2">
                                                        <i class="fas fa-{{ $statusIcon }} me-1"></i>
                                                        {{ ucfirst($request->transfer_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($request->approved_at && $request->modifier)
                                                        <div class="approval-info">
                                                            <small class="d-block mb-1">
                                                                <i class="fas fa-user me-1"></i>
                                                                <strong>By:</strong> {{ $request->modifier->name }}
                                                            </small>
                                                            <small class="d-block text-muted">
                                                                <i class="far fa-calendar-check me-1"></i>
                                                                {{ \Carbon\Carbon::parse($request->approved_at)->format('M d, Y h:i A') }}
                                                            </small>
                                                        </div>
                                                    @else
                                                        <small class="text-muted">-</small>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <!-- Notes Modal -->
                                            @if($request->transfer_notes && strlen($request->transfer_notes) > 80)
                                                <div class="modal fade" id="notesModal{{ $request->id }}" tabindex="-1" aria-labelledby="notesModalLabel{{ $request->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title" id="notesModalLabel{{ $request->id }}">
                                                                    <i class="fas fa-sticky-note me-2"></i>Transfer Notes
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="mb-0">{{ $request->transfer_notes }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-exchange-alt fa-4x text-muted mb-4"></i>
                                        <h4 class="text-muted mb-3">No Transfer History</h4>
                                        <p class="text-muted mb-4">You don't have any approved or rejected transfer requests yet.</p>
                                        <a href="{{ route('transfer.request.form') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Submit New Transfer Request
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('transfer.request.form') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Transfer Request Form
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
