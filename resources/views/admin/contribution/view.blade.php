@extends('layouts.admin')
@section('title', 'View Contribution')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="/">Home</a></li>
  <li class="breadcrumb-item"><a href="javascript:void(0);">Contribution</a></li>
  <li class="breadcrumb-item active">View Contribution</li>
@endsection

@section('content')

  <script src="/admin/js/contribution.js"></script>

  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body mt-2">

          <div class="col-lg-10 offset-1">

            <form action="{{ route('view.contribution') }}" method="post">
              @csrf

              <div class="form-row">

                <div class="form-group col-md-12">
                  <label for="contribution_year">Year</label>
                  <input type="text" class="form-control" id="contribution_year" name="contribution_year" data-provide="datepicker" data-date-autoclose="true" value="{{ $contribution_year }}">
                </div>

                <div class="form-group col-md-12">
                  <label for="team_id">Team</label>
                  <select class="form-control" id="team_id" name="team_id">
                    @foreach($teams as $team)
                      <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                  </select>
                </div>

              </div>

              <div class="form-group">
                <div class="text-center">
                  <button type="submit" class="btn btn-blue waves-effect waves-light">
                    View Contribution
                  </button>
                </div>
              </div>

            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="card-box">
        <h3 class="text-center"><u>Contribution of {{ $contribution_year }}</u></h3>
        <div class="table-responsive">
          <table class="table table-bordered mb-0 mt-3" id="contribution_table">
            <thead>
            <tr>
              <th>Name</th>
              <th>Jan, {{ $contribution_year }}</th>
              <th>Feb, {{ $contribution_year }}</th>
              <th>Mar, {{ $contribution_year }}</th>
              <th>Apr, {{ $contribution_year }}</th>
              <th>May, {{ $contribution_year }}</th>
              <th>Jun, {{ $contribution_year }}</th>
              <th>Jul, {{ $contribution_year }}</th>
              <th>Aug, {{ $contribution_year }}</th>
              <th>Sep, {{ $contribution_year }}</th>
              <th>Oct, {{ $contribution_year }}</th>
              <th>Nov, {{ $contribution_year }}</th>
              <th>Dec, {{ $contribution_year }}</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>

            @php $contributed_amount = []; @endphp

            @for($index=0; $index<count($contributionAmountPerMonth); $index++)

              @php $months = explode(",",$contributionAmountPerMonth[$index]['monthsString']) ; @endphp
              @php $attendanceMonths = explode(",",$contributionAmountPerMonth[$index]['attendanceString']) ; @endphp

              <tr>
                <td>{{ $contributionAmountPerMonth[$index]['name'] }}</td>
                @php $total_amount = 0; @endphp
                @php $monthCount = 0; @endphp
                @foreach($months as $month)
                  @php $total_amount += $month ; @endphp
                  <td>
                    {{ $month }}<br>
                    @if($attendanceMonths[$monthCount]>0)
                      <span class="badge badge-success badge-pill"><span class="fe-user-check"></span></span>
                    @else
                      <span class="badge badge-danger badge-pill"><span class="fe-user-x"></span></span>
                    @endif
                  </td>
                  @php
                    if(!isset($contributed_amount[$monthCount])) $contributed_amount[$monthCount] = 0;
                    $contributed_amount[$monthCount] += $month;
                    $monthCount++;
                  @endphp
                @endforeach
                <td>{{ $total_amount }}</td>
              </tr>
            @endfor

            </tbody>

            <tfoot>
            <th>Total</th>
            @foreach($contributed_amount as $collection)
              <th>{{ $collection }}</th>
            @endforeach
            <th>{{ array_sum($contributed_amount) }}</th>

            </tfoot>

          </table>
        </div>
      </div>
    </div>

  </div>

@endsection
