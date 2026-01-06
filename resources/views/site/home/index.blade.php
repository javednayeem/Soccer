@extends('layouts.site')
@section('title', $activeLeague ? $activeLeague->name : 'Football League')
@section('subtitle', $activeLeague ? $activeLeague->subtitle : 'Latest Football League Updates')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if($liveMatch)
                    <div class="match-status-indicator mb-3">
                        @if($liveMatch->status === 'live')
                            <span class="badge badge-danger p-2">
                        <i class="fas fa-circle text-white mr-1" style="font-size: 8px;"></i>
                        LIVE NOW
                    </span>
                        @else
                            <span class="badge badge-secondary p-2">
                        <i class="fas fa-flag-checkered mr-1"></i>
                        RECENT MATCH
                    </span>
                        @endif
                    </div>

                    <div class="d-flex team-vs">
                        <span class="score">{{ isset($liveMatch->home_team_score) ? $liveMatch->home_team_score : 0 }}-{{ isset($liveMatch->away_team_score) ? $liveMatch->away_team_score : 0 }}</span>
                        <div class="team-1 w-50">
                            <div class="team-details w-100 text-center">
                                <img src="/site/images/teams/{{ $liveMatch->homeTeam->logo }}" alt="{{ $liveMatch->homeTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                <h3>{{ $liveMatch->homeTeam->name }}
                                    @if($liveMatch->status === 'finished')
                                        <span class="result-badge">
                                    ({{ $liveMatch->home_team_score > $liveMatch->away_team_score ? 'win' : ($liveMatch->home_team_score == $liveMatch->away_team_score ? 'draw' : 'loss') }})
                                </span>
                                    @endif
                                </h3>
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
                                <img src="/site/images/teams/{{ $liveMatch->awayTeam->logo }}" alt="{{ $liveMatch->awayTeam->name }}" class="img-fluid" style="max-height: 80px;">
                                <h3>{{ $liveMatch->awayTeam->name }}
                                    @if($liveMatch->status === 'finished')
                                        <span class="result-badge">
                                    ({{ $liveMatch->away_team_score > $liveMatch->home_team_score ? 'win' : ($liveMatch->away_team_score == $liveMatch->home_team_score ? 'draw' : 'loss') }})
                                </span>
                                    @endif
                                </h3>
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

                    <!-- Match details footer -->
                    <div class="match-details-footer text-center mt-3">
                        <small class="text-muted">
                            {{ isset($liveMatch->league->name) ? $liveMatch->league->name : 'Unknown League' }} •
                            {{ \Carbon\Carbon::parse($liveMatch->match_date)->format('M d, Y H:i') }}
                            @if($liveMatch->venue)
                                • {{ $liveMatch->venue }}
                            @endif
                        </small>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h3>No Matches Available</h3>
                        <p>There are currently no live or recent matches to display.</p>
                    </div>
                @endif
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
                                            <img src="/site/images/teams/{{ $nextMatch->homeTeam->logo }}" alt="{{ $nextMatch->homeTeam->name }}" style="max-height: 60px;">
                                            <h3>
                                                <a href="/team/{{ $nextMatch->homeTeam->id }}/players" class="text-white" style="text-decoration: none">
                                                    {{ $nextMatch->homeTeam->name }}
                                                </a>
                                            </h3>
                                        </div>
                                        <div>
                                            <span class="vs"><span>VS</span></span>
                                        </div>
                                        <div class="team-2 text-center">
                                            <img src="/site/images/teams/{{ $nextMatch->awayTeam->logo }}" alt="{{ $nextMatch->awayTeam->name }}" style="max-height: 60px;">
                                            <h3>
                                                <a href="/team/{{ $nextMatch->awayTeam->id }}/players" class="text-white" style="text-decoration: none">
                                                    {{ $nextMatch->awayTeam->name }}
                                                </a>
                                            </h3>
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
                        <div class="table-responsive">
                            <table class="table custom-table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px;">P</th>
                                    <th style="min-width: 150px;">Team</th>
                                    <th class="text-center" style="width: 50px;">MP</th>
                                    <th class="text-center" style="width: 45px;">W</th>
                                    <th class="text-center" style="width: 45px;">D</th>
                                    <th class="text-center" style="width: 45px;">L</th>
                                    <th class="text-center" style="width: 45px;">GF</th>
                                    <th class="text-center" style="width: 45px;">GA</th>
                                    <th class="text-center" style="width: 50px;">GD</th>
                                    <th class="text-center" style="width: 50px;">PTS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($league->standings as $standing)
                                    <tr class="align-middle">
                                        <td class="text-center fw-bold">{{ $standing->position }}</td>
                                        <td>
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <div style="flex-shrink: 0;">
                                                    <img src="{{ asset('site/images/teams/' . $standing->team->logo) }}"
                                                         alt="{{ $standing->team->name }}"
                                                         class="rounded-circle border border-light"
                                                         style="width: 24px; height: 24px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                </div>
                                                <div style="min-width: 0; flex: 1;">
                                                    <a href="/team/{{ $standing->team->id }}/players"
                                                       class="text-white text-decoration-none"
                                                       style="font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">
                                                        {{ $standing->team->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $standing->played }}</td>
                                        <td class="text-center text-success fw-bold">{{ $standing->won }}</td>
                                        <td class="text-center">{{ $standing->drawn }}</td>
                                        <td class="text-center text-danger">{{ $standing->lost }}</td>
                                        <td class="text-center">{{ $standing->goals_for }}</td>
                                        <td class="text-center">{{ $standing->goals_against }}</td>
                                        <td class="text-center fw-bold {{ $standing->goal_difference > 0 ? 'text-success' : ($standing->goal_difference < 0 ? 'text-danger' : '') }}">
                                            {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                        </td>
                                        <td class="text-center fw-bold" style="background-color: rgba(0,0,0,0.3);">{{ $standing->points }}</td>
                                    </tr>
                                @endforeach

                                @if($standings->count() == 0)
                                    <tr>
                                        <td colspan="10" class="text-center py-3">
                                            <div class="text-muted" style="font-size: 0.9rem;">
                                                <i class="fas fa-table me-1"></i>No standings
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container">

            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12 title-section d-flex justify-content-between align-items-center">
                    <h2 class="heading mb-0 text-dark">Top Scorers</h2>
                </div>
            </div>

            <!-- Scorers Grid -->
            <div class="row">

                @foreach($player_statistics as $index => $stat)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="scorer-card p-3 bg-white rounded shadow-sm position-relative">

                            <div class="rank-badge">
                                {{ $index + 1 }}
                            </div>

                            <div class="d-flex align-items-center">

                                <img src="{{ str_contains($stat->player->photo, 'site/images/players/') ? asset($stat->player->photo) : asset('site/images/players/' . $stat->player->photo) }}" class="player-photo" onerror="this.src='/site/images/players/default_player.jpg'">

                                <div class="ml-3">
                                    <h5 class="mb-1 player-name text-dark">
                                        {{ $stat->player->first_name }} {{ $stat->player->last_name }}
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <img src="/site/images/teams/{{ $stat->player->team->logo ?? '' }}" class="team-logo mr-2" onerror="this.src='/site/images/teams/default_team.png'">
                                        <span class="team-name">{{ $stat->player->team->short_name ?? $stat->player->team->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="goals-box mt-3">
                                <span class="goals-number">{{ $stat->goals }}</span>
                                <span class="goals-label">Goals</span>
                            </div>

                            <div class="goals-box mt-3">
                                <span class="goals-number">{{ $stat->assists }}</span>
                                <span class="goals-label">Assists</span>
                            </div>

                        </div>
                    </div>
                @endforeach

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

    {{--<div class="site-section">--}}
    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-6 title-section">--}}
    {{--<h2 class="heading">Videos</h2>--}}
    {{--</div>--}}
    {{--<div class="col-6 text-right">--}}
    {{--<div class="custom-nav">--}}
    {{--<a href="#" class="js-custom-prev-v2"><span class="icon-keyboard_arrow_left"></span></a>--}}
    {{--<span></span>--}}
    {{--<a href="#" class="js-custom-next-v2"><span class="icon-keyboard_arrow_right"></span></a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}


    {{--<div class="owl-4-slider owl-carousel">--}}
    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Dogba set for Juvendu return?</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_2.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Kai Nets Double To Secure Comfortable Away Win</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Romolu to stay at Real Nadrid?</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_1.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Dogba set for Juvendu return?</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_2.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Kai Nets Double To Secure Comfortable Away Win</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="item">--}}
    {{--<div class="video-media">--}}
    {{--<img src="/site/images/img_3.jpg" alt="Image" class="img-fluid">--}}
    {{--<a href="https://vimeo.com/139714818" class="d-flex play-button align-items-center" data-fancybox>--}}
    {{--<span class="icon mr-3">--}}
    {{--<span class="icon-play"></span>--}}
    {{--</span>--}}
    {{--<div class="caption">--}}
    {{--<h3 class="m-0">Romolu to stay at Real Nadrid?</h3>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}

    @if($events->count())
        <div class="latest-news">
            <div class="container">
                <div class="row">
                    <div class="col-12 title-section">
                        <h2 class="heading">Events</h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    @foreach($events as $event)
                        <div class="col-md-4 pl-2">
                            <div class="post-entry" onclick="window.location.href='{{ url('/event/'.$event->event_id) }}'" style="cursor:pointer;">
                                <a href="/event/{{ $event->event_id }}">
                                    <img src="{{ asset('site/images/events/' . $event->event_image) }}" alt="{{ $event->event_name }}" class="img-fluid">
                                </a>
                                <div class="caption">
                                    <div class="caption-inner">
                                        <h3 class="mb-3">{{ $event->event_name }}</h3>
                                        <div class="author d-flex align-items-center">
                                            <div class="img mb-2 mr-3">
                                                <img src="{{ asset('site/images/events/' . $event->event_image) }}" alt="">
                                            </div>
                                            <div class="text">
                                                <h4>{{ $event->event_name }}</h4>
                                                <span>{{ formatDate($event->event_date) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif


    <div class="container site-section">
        <div class="row">
            <div class="col-6 title-section">
                <h2 class="heading">Our Blog</h2>
            </div>
        </div>
        <div class="row">
            <!--
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
            </div> -->
        </div>
    </div>

@endsection
