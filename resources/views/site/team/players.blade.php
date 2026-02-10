@extends('layouts.site')
@section('title', $team->name . ' - Players')
@section('subtitle', 'Meet all players from ' . $team->name)

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            <!-- Team Header -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('site/images/teams/' . $team->logo) }}"
                             alt="{{ $team->name }}"
                             class="rounded-circle mr-3"
                             style="width: 80px; height: 80px; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                        <div>
                            <h1 class="heading text-dark mb-2">{{ $team->name }}</h1>
                            @if($team->short_name)
                                <p class="text-muted mb-1">{{ $team->short_name }}</p>
                            @endif
                            <p class="text-muted mb-0">{{ $players->count() }} Players</p>
                        </div>
                    </div>

                    <!-- Team Info Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-primary mb-1">{{ $players->where('position', 'Goalkeeper')->count() }}</h4>
                                    <small class="text-muted">Goalkeepers</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-success mb-1">{{ $players->where('position', 'Defender')->count() }}</h4>
                                    <small class="text-muted">Defenders</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-info mb-1">{{ $players->where('position', 'Midfielder')->count() }}</h4>
                                    <small class="text-muted">Midfielders</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-warning mb-1">{{ $players->where('position', 'Forward')->count() }}</h4>
                                    <small class="text-muted">Forwards</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-success mb-1">{{ $players->where('payment_status', '1')->count() }}</h4>
                                    <small class="text-muted">Paid Players</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-3">
                                    <h4 class="text-danger mb-1">{{ $players->where('payment_status', '!=', '1')->count() }}</h4>
                                    <small class="text-muted">Not Paid Players</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($players as $player)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="player-card-new" onclick="loadPlayerDetails({{ $player->id }})">
                            <!-- Payment Status Icon -->
                            <div class="payment-status-icon">
                                <img src="{{ $player->payment_status == '1' ? asset('site/images/check-mark.png') : asset('site/images/cross-mark.png') }}"
                                     alt="Payment Status">
                            </div>

                            <!-- Team Logo Watermark -->
                            <div class="team-watermark">
                                <img src="{{ asset('site/images/teams/' . $team->logo) }}"
                                     alt="{{ $team->name }}"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                            </div>

                            <div class="player-photo-container">
                                <img src="{{ str_contains($player->photo, 'site/images/players/') ? asset($player->photo) : asset('site/images/players/' . $player->photo) }}"
                                     alt="{{ $player->first_name }} {{ $player->last_name }}"
                                     class="player-main-photo"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/players/default_player.jpg') }}';">
                            </div>

                            <div class="player-info-overlay">
                                @if($player->jersey_number)
                                    <div class="player-jersey-number">
                                        #{{ $player->jersey_number }}
                                    </div>
                                @endif
                                <div class="player-name">
                                    {{ $player->first_name }}<br>
                                    <strong>{{ $player->last_name }}</strong>
                                </div>
                                <div class="player-position">
                                    {{ ucfirst($player->position) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($players->count() == 0)
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="mdi mdi-account-off display-4 text-muted"></i>
                    </div>
                    <h4 class="text-dark">No Players Found</h4>
                    <p class="text-muted">This team doesn't have any active players yet.</p>
                </div>
            @endif

        </div>
    </div>

    <div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="playerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="playerModalLabel">Player Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="playerModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading player details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
