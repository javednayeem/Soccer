@extends('layouts.site')
@section('title', 'Schedule')
@section('subtitle', 'Stay updated with our latest matches, results, and upcoming fixtures. Follow our team\'s journey through the season.')

@section('content')

    <div class="site-section bg-light">
        <div class="container">

        @if($nextTwoMatches->count() > 0)
            <!-- Upcoming Matches Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-dark mb-1">Upcoming Matches</h2>
                                <p class="text-secondary mb-0">Next exciting fixtures</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary px-3 py-2 bg-primary text-white">
                                    <i class="mdi mdi-calendar-clock mr-1"></i>
                                    {{ $nextTwoMatches->count() }} Match{{ $nextTwoMatches->count() > 1 ? 'es' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Matches Cards -->
                <div class="row">
                    @foreach($nextTwoMatches as $match)
                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <!-- Match Header -->
                                    <div class="text-center mb-4">
                                        <span class="badge badge-info px-3 py-2 bg-info text-white mb-2">
                                            {{ isset($match->competition) ? $match->competition : 'Friendly Match' }}
                                        </span>
                                        <h5 class="text-muted mb-1">{{ $match->match_date->format('l, F j, Y') }}</h5>
                                        <h4 class="text-primary fw-bold">{{ $match->match_date->format('g:i A') }}</h4>
                                        <p class="text-dark mb-0">
                                            <i class="mdi mdi-map-marker text-danger mr-1"></i>
                                            {{ isset($match->venue) ? $match->venue : 'Venue TBA' }}
                                        </p>
                                    </div>

                                    <!-- Teams -->
                                    <div class="widget-vs">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <!-- Home Team -->
                                            <div class="team text-center flex-fill">
                                                <a href="/team/{{ $match->homeTeam->id }}/players" class="text-dark" style="text-decoration: none">
                                                    <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                                         alt="{{ $match->homeTeam->name }}"
                                                         class="img-fluid rounded-circle border border-secondary mb-3"
                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                    <h5 class="fw-bold text-dark mb-1">{{ $match->homeTeam->name }}</h5>
                                                </a>
                                                @if($match->homeTeam->short_name)
                                                    <small class="text-muted">({{ $match->homeTeam->short_name }})</small>
                                                @endif
                                            </div>

                                            <!-- VS -->
                                            <div class="vs-section text-center mx-4">
                                                <span class="vs bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle"
                                                      style="width: 60px; height: 60px; font-size: 14px; font-weight: bold;">
                                                    VS
                                                </span>
                                                <div class="mt-2">
                                                    <small class="text-muted">Upcoming</small>
                                                </div>
                                            </div>

                                            <!-- Away Team -->
                                            <div class="team text-center flex-fill">
                                                <a href="/team/{{ $match->awayTeam->id }}/players" class="text-dark" style="text-decoration: none">
                                                    <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                                         alt="{{ $match->awayTeam->name }}"
                                                         class="img-fluid rounded-circle border border-secondary mb-3"
                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                    <h5 class="fw-bold text-dark mb-1">{{ $match->awayTeam->name }}</h5>
                                                </a>
                                                @if($match->awayTeam->short_name)
                                                    <small class="text-muted">({{ $match->awayTeam->short_name }})</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Match Footer -->
                                    <div class="text-center mt-4 pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="mdi mdi-clock-outline mr-1"></i>
                                            {{ $match->match_date->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endif

        @if($otherUpcomingMatches->count() > 0)
            <!-- All Scheduled Matches Header -->
                <div class="row mt-5 mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="heading text-dark mb-1">All Scheduled Matches</h2>
                                <p class="text-secondary mb-0">Complete fixture list for the season</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-success px-3 py-2 bg-success text-white">
                                    <i class="mdi mdi-calendar-multiple mr-1"></i>
                                    {{ $otherUpcomingMatches->count() }} Total
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Scheduled Matches Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless mb-0">
                                <thead class="thead-light">
                                <tr class="bg-primary text-white">
                                    <th class="py-3 border-0" style="width: 20%">Date & Time</th>
                                    <th class="py-3 border-0 text-center">Match</th>
                                    <th class="py-3 border-0" style="width: 200px;">Competition</th>
                                    <th class="py-3 border-0" style="width: 150px;">Venue</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($otherUpcomingMatches as $match)
                                    <tr class="border-bottom">

                                        <td class="align-middle py-3">
                                            <div class="d-flex flex-column">
                                                <h4 class="fw-bold text-dark">{{ $match->match_date->format('M j, Y') }}</h4>
                                                <h6>{{ $match->match_date->format('g:i A') }}</h6>
                                                <span class="badge badge-secondary badge-sm mt-1">
                                                    {{ $match->match_date->format('D') }}
                                                </span>
                                            </div>
                                        </td>


                                        <td class="align-middle py-3 text-center">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <div class="d-flex align-items-center flex-fill">
                                                    <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                                         alt="{{ $match->homeTeam->name }}"
                                                         class="rounded-circle border border-secondary me-3"
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                    <div>
                                                        <span class="fw-bold text-dark d-block ml-2">
                                                            <a href="/team/{{ $match->homeTeam->id }}/players" class="text-dark" style="text-decoration: none">
                                                            {{ $match->homeTeam->name }}
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="mx-3">
                                                    <span class="badge badge-light border text-muted px-2">VS</span>
                                                </div>

                                                <div class="d-flex align-items-center flex-fill text-right">
                                                    <div class="me-3 text-end">
                                                        <span class="fw-bold text-dark d-block mr-2">
                                                            <a href="/team/{{ $match->awayTeam->id }}/players" class="text-dark" style="text-decoration: none">
                                                            {{ $match->awayTeam->name }}
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                                         alt="{{ $match->awayTeam->name }}"
                                                         class="rounded-circle border border-secondary"
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('site/images/teams/default_team.png') }}';">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle py-3">
                                            <span class="badge badge-info bg-info text-white px-3 py-2">
                                                {{ isset($match->competition) ? $match->competition : 'Friendly' }}
                                            </span>
                                        </td>

                                        <td class="align-middle py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-map-marker text-danger me-2"></i>
                                                <span class="text-dark">{{ $match->venue ? $match->venue : 'TBA' }}</span>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        @endif

        <!-- Empty State -->
            @if($nextTwoMatches->count() == 0 && $otherUpcomingMatches->count() == 0)
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="mdi mdi-calendar-remove display-4 text-muted"></i>
                        </div>
                        <h3 class="text-dark">No Upcoming Matches</h3>
                        <p class="text-muted">Check back later for the latest schedule updates.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
