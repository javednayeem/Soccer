@extends('layouts.site')
@section('title', 'Players')
@section('subtitle', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, molestias repudiandae pariatur.')

@section('content')

    <div class="site-section">
        <div class="container">
            @foreach($teams as $team)
                <div class="row">
                    <div class="col-6 title-section">
                        <h2 class="heading">{{ $team->name }}</h2>
                    </div>
                    <div class="col-6 text-right">
                        <div class="custom-nav">
                            <a href="javascript:void(0);" class="js-custom-prev-v2-{{ $team->id }}"><span class="icon-keyboard_arrow_left"></span></a>
                            <span></span>
                            <a href="javascript:void(0);" class="js-custom-next-v2-{{ $team->id }}"><span class="icon-keyboard_arrow_right"></span></a>
                        </div>
                    </div>
                </div>

                <div class="owl-4-slider owl-carousel team-slider-{{ $team->id }} mb-5">
                    @foreach($team->players as $player)
                        <div class="item">
                            <div class="video-media">
                                <img src="site/images/players/{{ $player->photo }}" alt="{{ $player->first_name }} {{ $player->last_name }}" class="img-fluid">
                                <a href="javascript:void(0);" class="d-flex play-button align-items-center player-detail-btn"
                                   data-player-id="{{ $player->id }}">
                                <span class="icon mr-3">
                                    <span class="icon-play"></span>
                                </span>
                                    <div class="caption">
                                        <span class="meta">#{{ isset($player->jersey_number) ? $player->jersey_number : 'N/A' }} / {{ isset($player->position) ? ucfirst($player->position) : 'Player' }}</span>
                                        <h3 class="m-0">{{ $player->first_name }} {{ $player->last_name }}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
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