@extends('layouts.admin')
@section('title', 'Leagues')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#add_league_modal">
                                <i class="md md-add"></i> Add New League
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>League Name</th>
                                    <th>Season</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="league_table">
                                @foreach($leagues as $league)
                                    <tr id="league_{{ $league->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $league->name }}</td>
                                        <td>{{ $league->season }}</td>
                                        <td>{{ \Carbon\Carbon::parse($league->start_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($league->end_date)->format('M d, Y') }}</td>
                                        <td>
                                            @if($league->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-primary"
                                                    onclick="editLeague(this)"
                                                    data-id="{{ $league->id }}"
                                                    data-name="{{ $league->name }}"
                                                    data-season="{{ $league->season }}"
                                                    data-start-date="{{ $league->start_date }}"
                                                    data-end-date="{{ $league->end_date }}"
                                                    data-is-active="{{ $league->is_active }}"
                                                    title="Edit League">
                                                <i class="fe-edit"></i>
                                            </button>

                                            <button class="btn btn-xs btn-icon waves-effect waves-light btn-danger" onclick="deleteLeague({{ $league->id }})">
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
        </div>
    </div>

    <div id="add_league_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New League</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">League Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter league name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="season" class="control-label">Season <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="season" placeholder="e.g., 2024-2025">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="control-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="control-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" checked>
                                <label class="custom-control-label" for="is_active">Active League</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="add_league_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_league_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit League</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="league_id" value="0">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_name" class="control-label">League Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" placeholder="Enter league name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_season" class="control-label">Season <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_season" placeholder="e.g., 2024-2025">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_start_date" class="control-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_end_date" class="control-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_end_date">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="edit_is_active">
                                <label class="custom-control-label" for="edit_is_active">Active League</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" id="edit_league_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
