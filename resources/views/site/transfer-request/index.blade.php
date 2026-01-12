@extends('layouts.site')
@section('title', 'Player Transfer Request')
@section('subtitle', 'Request to change your football team')

@section('content')

    <div class="transfer-request-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>Team Transfer Request
                            </h4>
                        </div>

                        <div class="card-body p-4 p-md-5">

                                <div class="row">

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="from_team_id" class="form-label fw-bold">
                                                Current Team <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-select border-start-0" id="from_team_id" name="from_team_id" required data-placeholder="Select your current team">
                                                    <option value="" selected disabled>-- Select Current Team --</option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-text text-muted">
                                                Select the team you currently play for
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="player_id" class="form-label fw-bold">
                                                Player Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-select border-start-0"
                                                        id="player_id"
                                                        name="player_id"
                                                        required
                                                        disabled
                                                        data-placeholder="Select your name">
                                                    <option value="" selected disabled>-- Select Your Name --</option>
                                                    <!-- Players will be loaded via AJAX -->
                                                </select>
                                            </div>

                                            <!-- Loading Indicator -->
                                            <div id="playerLoading" class="mt-2" style="display: none;">
                                                <div class="d-flex align-items-center">
                                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <span class="text-muted">Loading players...</span>
                                                </div>
                                            </div>

                                            <!-- No Players Message -->
                                            <div id="noPlayers" class="mt-2" style="display: none;">
                                                <div class="alert alert-warning mb-0 py-2">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    No active players found for the selected team.
                                                </div>
                                            </div>

                                            <div class="form-text text-muted">
                                                Select your name from the list of players in your current team
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <div class="form-group">
                                            <label for="to_team_id" class="form-label fw-bold">
                                                Destination Team <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-select border-start-0"
                                                        id="to_team_id"
                                                        name="to_team_id"
                                                        required
                                                        data-placeholder="Select team to join">
                                                    <option value="" selected disabled>-- Select Destination Team --</option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-text text-muted">
                                                Select the team you want to transfer to
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label for="transfer_notes" class="form-label fw-bold">
                                                <i class="fas fa-sticky-note me-1 text-primary"></i>
                                                Additional Notes (Optional)
                                            </label>
                                            <textarea class="form-control text-dark border-dark" id="transfer_notes" name="transfer_notes" rows="4" placeholder="Please provide any additional information or reasons for your transfer request..."></textarea>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small class="text-muted">
                                                    This will help the team manager understand your request
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-danger btn-lg px-4" id="submit_transfer_request">
                                        <i class="fas fa-paper-plane me-1"></i> Submit Transfer Request
                                    </button>
                                </div>

                                <div class="alert alert-info border-0 bg-light">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Please note: Only one pending transfer request is allowed per player.
                                </div>

                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-muted mb-0">
                            Need help? Contact the team manager at <a href="mailto:manager@example.com" class="text-decoration-none">manager@example.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
