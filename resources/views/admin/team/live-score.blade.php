@extends('layouts.admin')
@section('title', 'Live Score')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">

                <button type="button" class="btn btn-sm btn-dark waves-effect waves-light float-right" data-toggle="modal" data-target="#add_score_modal">
                    <i class="mdi mdi-plus-circle mr-1"></i>Add Live Score
                </button>

                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Team</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                        </thead>

                        <tbody id="score_table">

                        @foreach($live_scores as $score)
                            <tr id="score_{{ $score->id }}">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $score->team1->team_name }} vs {{ $score->team2->team_name }}</td>
                                <td>{{ $score->team_score_1 }} - {{ $score->team_score_2 }}</td>

                                <td>
                                    @if($score->live_status == '1')
                                        <span class="badge badge-danger font-14">Live</span>
                                    @else
                                        {{--<span class="badge badge-danger font-14"></span>--}}
                                    @endif
                                </td>

                                <td class="text-center">

                                    <button type="button" class="btn btn-blue btn-xs waves-effect waves-light" onclick="editScore('{{ $score->id }}', '{{ $score->team_1 }}', '{{ $score->team_2 }}', '{{ $score->team_score_1 }}', '{{ $score->team_score_2 }}', '{{ $score->live_status }}')" title="Update Live Score">
                                        <i class="fe-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-xs btn-danger waves-effect waves-light" onclick="deleteScore({{ $score->id }})" title="Delete Section">
                                        <i class="fe-trash-2"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div id="add_score_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Live Score</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">

                    <input type="hidden" id="score_id" value="0">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_1" class="control-label">Team 1 <span class="text-danger">*</span></label>
                                <select class="form-control" id="team_1">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->team_id }}">{{ $team->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_score_1" class="control-label">Team 1 Score <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="team_score_1" value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_2" class="control-label">Team 2 <span class="text-danger">*</span></label>
                                <select class="form-control" id="team_2">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->team_id }}">{{ $team->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_score_2" class="control-label">Team 2 Score <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="team_score_2" value="0">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group checkbox checkbox-primary mb-2">
                                <input id="live_status" type="checkbox" checked>
                                <label for="live_status">Active</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" data-dismiss="modal" id="add_score_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
