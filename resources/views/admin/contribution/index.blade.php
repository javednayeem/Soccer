@extends('layouts.admin')
@section('title', 'Insert Contribution')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="/">Home</a></li>
  <li class="breadcrumb-item">Contribution</li>
  <li class="breadcrumb-item active">Insert</li>
@endsection

@section('content')

  <script src="/admin/js/contribution.js"></script>

  <div class="row">

    <div class="col-md-3">
      <div class="card-box p-2">
        <div class="form-group">
          <label>Date</label>
          <input type="text" class="form-control" id="attendance_date" data-provide="datepicker" data-date-autoclose="true" value="{{ date('m/d/Y') }}">
        </div>

        <div class="form-group mt-2">
          <label>Contribution Amount</label>
          <input type="number" class="form-control" id="amount" value="0">
        </div>

        <button type="button" class="btn btn-blue btn-block mt-3" id="insert_attendance_contribution_button">
          Insert Contribution
        </button>
      </div>
    </div>

    <div class="col-md-9">
      <div class="card-box p-2">

        <div class="row align-items-center mb-2">
          <div class="col-md-6">
            <h4 class="header-title mb-0">Player List (Team Wise)</h4>
          </div>

          <div class="col-md-6 text-right">
            <select class="form-control form-control-sm w-50 float-right" id="team_filter">
              <option value="">-- Select Team --</option>
              @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="table-responsive">
          <table class="table table-bordered mt-3" id="contribution_table">
            <thead class="thead-light">
            <tr>
              <th width="40">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="select_all">
                  <label class="custom-control-label" for="select_all"></label>
                </div>
              </th>
              <th>Player</th>
              <th>Team</th>
              <th>Position</th>
              <th>Phone</th>
              <th>Email</th>
            </tr>
            </thead>

            <tbody id="player_table_body"></tbody>

          </table>
        </div>
      </div>
    </div>

  </div>

@endsection
