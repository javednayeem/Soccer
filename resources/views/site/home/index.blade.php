@extends('layouts.site')
@section('title', 'World Cup Event')
@section('subtitle', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, molestias repudiandae pariatur.')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if($liveMatch)
                    <div class="d-flex team-vs">
                        <span class="score">{{ $liveMatch->home_team_score }}-{{ $liveMatch->away_team_score }}</span>
                        <div class="team-1 w-50">
                            <div class="team-details w-100 text-center">
                                <img src="{{ $liveMatch->homeTeam->logo ? asset('storage/' . $liveMatch->homeTeam->logo) : '/site/images/logo_1.png' }}" alt="{{ $liveMatch->homeTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                <h3>{{ $liveMatch->homeTeam->name }} <span>({{ $liveMatch->home_team_score > $liveMatch->away_team_score ? 'win' : ($liveMatch->home_team_score == $liveMatch->away_team_score ? 'draw' : 'loss') }})</span></h3>
                                <ul class="list-unstyled">
                                    @foreach($liveMatch->events->where('team_id', $liveMatch->home_team_id)->where('type', 'goal')->take(4) as $event)
                                        <li>{{ $event->player->first_name }} {{ $event->player->last_name }} ({{ $event->minute }})</li>
                                    @endforeach
                                    @if($liveMatch->events->where('team_id', $liveMatch->home_team_id)->where('type', 'goal')->count() == 0)
                                        <li>No goals</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="team-2 w-50">
                            <div class="team-details w-100 text-center">
                                <img src="{{ $liveMatch->awayTeam->logo ? asset('storage/' . $liveMatch->awayTeam->logo) : '/site/images/logo_2.png' }}" alt="{{ $liveMatch->awayTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                <h3>{{ $liveMatch->awayTeam->name }} <span>({{ $liveMatch->away_team_score > $liveMatch->home_team_score ? 'win' : ($liveMatch->away_team_score == $liveMatch->home_team_score ? 'draw' : 'loss') }})</span></h3>
                                <ul class="list-unstyled">
                                    @foreach($liveMatch->events->where('team_id', $liveMatch->away_team_id)->where('type', 'goal')->take(4) as $event)
                                        <li>{{ $event->player->first_name }} {{ $event->player->last_name }} ({{ $event->minute }})</li>
                                    @endforeach
                                    @if($liveMatch->events->where('team_id', $liveMatch->away_team_id)->where('type', 'goal')->count() == 0)
                                        <li>No goals</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h3>No Live Matches Currently</h3>
                        <p>Check back later for live match updates.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="latest-news">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading">Latest News</h2>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="post-entry">
                        <a href="#">
                            <img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">
                        </a>
                        <div class="caption">
                            <div class="caption-inner">
                                <h3 class="mb-3">Romolu to stay at Real Nadrid?</h3>
                                <div class="author d-flex align-items-center">
                                    <div class="img mb-2 mr-3">
                                        <img src="/site/images/person_1.jpg" alt="">
                                    </div>
                                    <div class="text">
                                        <h4>Mellissa Allison</h4>
                                        <span>May 19, 2020 &bullet; Sports</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="post-entry">
                        <a href="#">
                            <img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">
                        </a>
                        <div class="caption">
                            <div class="caption-inner">
                                <h3 class="mb-3">Kai Nets Double To Secure Comfortable Away Win</h3>
                                <div class="author d-flex align-items-center">
                                    <div class="img mb-2 mr-3">
                                        <img src="/site/images/person_1.jpg" alt="">
                                    </div>
                                    <div class="text">
                                        <h4>Mellissa Allison</h4>
                                        <span>May 19, 2020 &bullet; Sports</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="post-entry">
                        <a href="#">
                            <img src="/site/images/img_2.jpg" alt="Image" class="img-fluid">
                        </a>
                        <div class="caption">
                            <div class="caption-inner">
                                <h3 class="mb-3">Dogba set for Juvendu return?</h3>
                                <div class="author d-flex align-items-center">
                                    <div class="img mb-2 mr-3">
                                        <img src="/site/images/person_1.jpg" alt="">
                                    </div>
                                    <div class="text">
                                        <h4>Mellissa Allison</h4>
                                        <span>May 19, 2020 &bullet; Sports</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="site-section bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    @if($nextMatch)
                        <div class="widget-next-match">
                            <div class="widget-title">
                                <h3>Next Match</h3>
                            </div>
                            <div class="widget-body mb-3">
                                <div class="widget-vs">
                                    <div class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                        <div class="team-1 text-center">
                                            <img src="{{ $nextMatch->homeTeam->logo ? asset('storage/' . $nextMatch->homeTeam->logo) : '/site/images/logo_1.png' }}" alt="{{ $nextMatch->homeTeam->name }}" style="max-height: 60px;">
                                            <h3>{{ $nextMatch->homeTeam->name }}</h3>
                                        </div>
                                        <div>
                                            <span class="vs"><span>VS</span></span>
                                        </div>
                                        <div class="team-2 text-center">
                                            <img src="{{ $nextMatch->awayTeam->logo ? asset('storage/' . $nextMatch->awayTeam->logo) : '/site/images/logo_2.png' }}" alt="{{ $nextMatch->awayTeam->name }}" style="max-height: 60px;">
                                            <h3>{{ $nextMatch->awayTeam->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center widget-vs-contents mb-4">
                                <h4>Premier League</h4>
                                <p class="mb-5">
                                    <span class="d-block">{{ $nextMatch->match_date->format('F jS, Y') }}</span>
                                    <span class="d-block">{{ $nextMatch->match_date->format('g:i A') }} GMT+0</span>
                                    <strong class="text-primary">{{ $nextMatch->venue }}</strong>
                                </p>

                                <div id="date-countdown2" class="pb-1" data-countdown="{{ $nextMatch->match_date->format('Y/m/d H:i:s') }}"></div>
                            </div>
                        </div>
                    @else
                        <div class="widget-next-match">
                            <div class="widget-title">
                                <h3>Next Match</h3>
                            </div>
                            <div class="text-center py-4">
                                <p>No upcoming matches scheduled.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="widget-next-match">
                        <table class="table custom-table">
                            <thead>
                            <tr>
                                <th>P</th>
                                <th>Team</th>
                                <th>W</th>
                                <th>D</th>
                                <th>L</th>
                                <th>PTS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($standings as $standing)
                                <tr>
                                    <td>{{ $standing->position }}</td>
                                    <td><strong class="text-white">{{ $standing->team->name }}</strong></td>
                                    <td>{{ $standing->won }}</td>
                                    <td>{{ $standing->drawn }}</td>
                                    <td>{{ $standing->lost }}</td>
                                    <td>{{ $standing->points }}</td>
                                </tr>
                            @endforeach
                            @if($standings->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No standings data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-6 title-section">
                    <h2 class="heading">Videos</h2>
                </div>
                <div class="col-6 text-right">
                    <div class="custom-nav">
                        <a href="#" class="js-custom-prev-v2"><span class="icon-keyboard_arrow_left"></span></a>
                        <span></span>
                        <a href="#" class="js-custom-next-v2"><span class="icon-keyboard_arrow_right"></span></a>
                    </div>
                </div>
            </div>


            <div class="owl-4-slider owl-carousel">
                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Dogba set for Juvendu return?</h3>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_2.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Kai Nets Double To Secure Comfortable Away Win</h3>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Romolu to stay at Real Nadrid?</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Dogba set for Juvendu return?</h3>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_2.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Kai Nets Double To Secure Comfortable Away Win</h3>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="video-media">
                        <img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">
                        <a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>
                <span class="icon mr-3">
                  <span class="icon-play"></span>
                </span>
                            <div class="caption">
                                <h3 class="m-0">Romolu to stay at Real Nadrid?</h3>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="container site-section">
        <div class="row">
            <div class="col-6 title-section">
                <h2 class="heading">Our Blog</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="custom-media d-flex">
                    <div class="img mr-4">
                        <img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">
                    </div>
                    <div class="text">
                        <span class="meta">May 20, 2020</span>
                        <h3 class="mb-4"><a href="#">Romolu to stay at Real Nadrid?</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus deserunt saepe tempora dolorem.</p>
                        <p><a href="#">Read more</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="custom-media d-flex">
                    <div class="img mr-4">
                        <img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">
                    </div>
                    <div class="text">
                        <span class="meta">May 20, 2020</span>
                        <h3 class="mb-4"><a href="#">Romolu to stay at Real Nadrid?</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus deserunt saepe tempora dolorem.</p>
                        <p><a href="#">Read more</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection