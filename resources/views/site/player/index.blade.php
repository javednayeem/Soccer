@extends('layouts.site')
@section('title', 'Players')
@section('subtitle', 'Meet our talented players across all teams. Click on any player to view their detailed profile. Without registration player is not allowed to play on the Match')

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            @foreach($teams as $team)
                @if($team->players->count() > 0)

                    <div class="row mb-4 align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('site/images/teams/' . $team->logo) }}"
                                     alt="{{ $team->name }}"
                                     class="rounded-circle mr-3"
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                <div>
                                    <h2 class="heading text-dark mb-1">
                                        <a href="/team/{{ $team->id }}/players" class="text-dark" style="text-decoration: none">
                                            {{ $team->name }}
                                        </a>
                                    </h2>
                                    @if($team->short_name)
                                        <p class="text-muted mb-0">{{ $team->short_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-right">
                            <div class="team-nav-controls">
                                <a href="javascript:void(0);" class="team-nav-btn team-nav-prev js-custom-prev-v2-{{ $team->id }}">
                                    <span class="icon-keyboard_arrow_left"></span>
                                </a>
                                <a href="javascript:void(0);" class="team-nav-btn team-nav-next js-custom-next-v2-{{ $team->id }}">
                                    <span class="icon-keyboard_arrow_right"></span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="owl-4-slider owl-carousel team-slider-{{ $team->id }} mb-5">
                        @foreach($team->players as $player)
                            <div class="item">
                                <div class="player-card-new" onclick="loadPlayerDetails({{ $player->id }})">

                                    <div class="payment-status-icon">
                                        <img src="{{ $player->payment_status == '1' ? asset('site/images/check-mark.png') : asset('site/images/cross-mark.png') }}"
                                             alt="Payment Status">
                                    </div>

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

                @endif
            @endforeach

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

    <script>
        jQuery(document).ready(function($) {
                    @foreach($teams as $team)
            var slider{{ $team->id }} = $('.team-slider-{{ $team->id }}').owlCarousel({
                    items: 4,
                    loop: true,
                    margin: 20,
                    autoplay: false,
                    nav: false,
                    dots: false,
                    responsive: {
                        0: { items: 1 },
                        576: { items: 2 },
                        768: { items: 3 },
                        992: { items: 4 }
                    }
                });

            $('.js-custom-next-v2-{{ $team->id }}').click(function() {
                slider{{ $team->id }}.trigger('next.owl.carousel');
            });

            $('.js-custom-prev-v2-{{ $team->id }}').click(function() {
                slider{{ $team->id }}.trigger('prev.owl.carousel');
            });
            @endforeach
        });


    </script>

@endsection
