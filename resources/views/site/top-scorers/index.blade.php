@extends('layouts.site')
@section('title', 'Top Scorers')
@section('subtitle', $league->name . ' - ' . $league->season)

@section('content')

    <div class="site-section bg-light">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="heading">Top Scorers</h2>
                    <p class="text-muted">{{ $league->name }} • {{ $league->season }}</p>
                </div>
            </div>

            <div class="top-scorers-wrapper">

                <table class="table table-hover scorers-table shadow-sm text-white">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th class="text-center">Goals</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($playerStatistics as $index => $stat)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>

                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="/site/images/players/{{ $stat->player->photo }}"
                                         class="rounded-circle mr-3"
                                         style="width:45px; height:45px; object-fit:cover;"
                                         onerror="this.src='/site/images/players/default_player.jpg'">

                                    <div>
                                        <strong>{{ $stat->player->first_name }} {{ $stat->player->last_name }}</strong>
                                        <div class="small">
                                            #{{ $stat->player->jersey_number ?: 'N/A' }} – {{ ucfirst($stat->player->position) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="/site/images/teams/{{ $stat->player->team->logo }}"
                                         style="width:32px;height:32px;object-fit:contain;margin-right:10px;"
                                         onerror="this.src='/site/images/teams/default_team.png'">

                                    {{ $stat->player->team->short_name ?: $stat->player->team->name }}
                                </div>
                            </td>

                            <td class="align-middle text-center">
                            <span class="badge badge-danger p-2" style="font-size:16px;">
                                {{ $stat->goals }}
                            </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection