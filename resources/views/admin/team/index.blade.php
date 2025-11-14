@extends('layouts.admin')
@section('title', 'Teams')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-1">

                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Team Name</th>
                            <th>Manager</th>
                            <th>Manager's Email</th>
                            <th>Manager's Phone</th>
                            <th>Payment Reference Number</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Registration Date</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                        </thead>

                        <tbody id="team_table">

                        @foreach($teams as $team)
                            <tr id="team_{{ $team->id }}">
                                <td>{{ $loop->index + 1 }}</td>

                                <td>{{ $team->name }}</td>
                                <td>{{ $team->team_manager }}</td>
                                <td>{{ $team->manager_email }}</td>
                                <td>{{ $team->manager_phone }}</td>
                                <td>{{ $team->payment_reference_number }}</td>

                                <td>
                                    @if($team->team_status == 'pending')
                                        <span class="badge badge-warning font-14">Pending</span>
                                    @elseif($team->team_status == 'approved')
                                        <span class="badge badge-success font-14">Approved</span>
                                    @else
                                        <span class="badge badge-danger font-14">Rejected</span>
                                    @endif
                                </td>

                                <td>
                                <div class="checkbox checkbox-success mb-2">
                                    <input id="active_{{ $team->id }}" type="checkbox" {{ $team->active == '1' ? 'checked' : '' }} onchange="updateTeamActiveStatus({{ $team->id }});">
                                    <label for="active_{{ $team->id }}">&nbsp;</label>
                                </div>
                                </td>

                                <td>{{ formatDateTime($team->created_at, 12) }}</td>

                                <td class="text-center">

                                    @if($team->team_status == 'pending')
                                        <button type="button" class="btn btn-blue btn-xs waves-effect waves-light" onclick="changeTeamStatus('{{ $team->id }}', 'approved')">
                                            <i class="mdi mdi-check-all mr-1"></i> Approve
                                        </button>

                                        <button type="button" class="btn btn-xs btn-danger waves-effect waves-light" onclick="changeTeamStatus('{{ $team->id }}', 'rejected')">
                                            <i class="mdi mdi-cancel mr-1"></i> Reject
                                        </button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

@endsection
