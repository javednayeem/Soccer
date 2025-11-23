@extends('layouts.site')
@section('title', 'Schedule')
@section('subtitle', 'Stay updated with our latest matches, results, and upcoming fixtures. Follow our team\'s journey through the season.')

@section('content')

    <div class="site-section bg-dark">
        <div class="container">

            @if($nextTwoMatches->count() > 0)
                <div class="row">
                    <div class="col-12 title-section">
                        <h2 class="heading">Upcoming Matches</h2>
                    </div>

                    @foreach($nextTwoMatches as $match)
                        <div class="col-lg-6 mb-4">
                            <div class="bg-light p-4 rounded">
                                <div class="widget-body">
                                    <div class="widget-vs">
                                        <div class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                            <div class="team-1 text-center">
                                                <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                                     alt="{{ $match->homeTeam->name }}" class="img-fluid" style="max-height: 60px;">
                                                <h3>{{ $match->homeTeam->name }}</h3>
                                            </div>
                                            <div>
                                                <span class="vs"><span>VS</span></span>
                                            </div>
                                            <div class="team-2 text-center">
                                                <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                                     alt="{{ $match->awayTeam->name }}" class="img-fluid" style="max-height: 60px;">
                                                <h3>{{ $match->awayTeam->name }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center widget-vs-contents mb-4">
                                    <h4>{{ isset($match->competition) ? $match->competition : 'Friendly Match' }}</h4>
                                    <p class="mb-5">
                                        <span class="d-block">{{ $match->match_date->format('F j, Y') }}</span>
                                        <span class="d-block">{{ $match->match_date->format('g:i A') }}</span>
                                        <strong class="text-primary">{{ isset($match->venue) ? $match->venue : 'Venue TBA' }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($otherUpcomingMatches->count() > 0)
                <div class="row mt-5">
                    <div class="col-12 title-section">
                        <h2 class="heading">All Scheduled Matches</h2>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive bg-light p-3 rounded">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Home Team VS Away Team</th>
                                    <th>Venue</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($otherUpcomingMatches as $match)
                                    <tr>
                                        <td class="align-middle">{{ $match->match_date->format('F j, Y') }}</td>
                                        <td class="align-middle">{{ $match->match_date->format('g:i A') }}</td>

                                        <td class="d-flex align-items-center">
                                            <img src="{{ asset('site/images/teams/' . $match->homeTeam->logo) }}"
                                                 alt="{{ $match->homeTeam->name }}"
                                                 style="height: 40px; width: 40px; object-fit: contain; margin-right: 10px;">
                                            {{ $match->homeTeam->name }}
                                        </td>

                                        <td class="d-flex align-items-center">
                                            <img src="{{ asset('site/images/teams/' . $match->awayTeam->logo) }}"
                                                 alt="{{ $match->awayTeam->name }}"
                                                 style="height: 40px; width: 40px; object-fit: contain; margin-right: 10px;">
                                            {{ $match->awayTeam->name }}
                                        </td>

                                        <td class="align-middle">{{ $match->venue ? $match->venue : 'Venue TBA' }}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
