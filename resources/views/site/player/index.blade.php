@extends('layouts.site')
@section('title', 'Players')
@section('subtitle', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, molestias repudiandae pariatur.')

@section('content')

    <div class="site-section">
        <div class="container">

            @foreach($teams as $team)

                @if($team->players->count() > 0)

                    <div class="row mb-4 align-items-center">
                        <div class="col-6 title-section">
                            <h2 class="heading">{{ $team->name }}</h2>
                        </div>
                        <div class="col-6 text-right">
                            <div class="custom-nav">
                                <a href="javascript:void(0);" class="js-custom-prev-v2-{{ $team->id }}">
                                    <span class="icon-keyboard_arrow_left"></span>
                                </a>
                                <span></span>
                                <a href="javascript:void(0);" class="js-custom-next-v2-{{ $team->id }}">
                                    <span class="icon-keyboard_arrow_right"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="owl-4-slider owl-carousel team-slider-{{ $team->id }} mb-5">
                        @foreach($team->players as $player)
                            <div class="item">
                                <div class="player-card">

                                    <div class="player-card-image">
                                        <img src="{{ str_contains($player->photo, 'site/images/players/') ? asset($player->photo) : asset('site/images/players/' . $player->photo) }}"
                                             alt="{{ $player->first_name }} {{ $player->last_name }}"
                                             class="img-fluid" style="height: 400px"
                                             onerror="this.onerror=null; this.src='{{ asset('site/images/players/default_player.jpg') }}';">
                                    </div>

                                    <div class="player-card-overlay-always p-3">
                                        <div class="player-number">
                                            #{{ isset($player->jersey_number) ? $player->jersey_number : 'N/A' }}
                                        </div>

                                        <div class="player-position">
                                            {{ isset($player->position) ? ucfirst($player->position) : 'Player' }}
                                        </div>

                                        <h3 class="player-name m-0">
                                            {{ $player->first_name }} {{ $player->last_name }}
                                        </h3>
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
                    margin: 10,
                    autoplay: false,
                    nav: false,
                    dots: false,
                    responsive:{
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
