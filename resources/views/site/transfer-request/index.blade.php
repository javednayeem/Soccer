@extends('layouts.site')
@section('title', 'Player Transfer Request')
@section('subtitle', 'Request to change your football team')

@section('content')

    <div class="transfer-request-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <div class="header-icon mb-4">
                            <i class="fas fa-exchange-alt fa-3x text-primary"></i>
                        </div>
                        <h1 class="display-5 fw-bold text-primary mb-3">Team Transfer Request</h1>
                        <p class="lead text-muted">
                            Submit a request to transfer to a different team. Your request will be reviewed by the team manager.
                        </p>
                        <div class="alert alert-info border-0 bg-light">
                            <i class="fas fa-info-circle me-2"></i>
                            Please note: Only one pending transfer request is allowed per player.
                        </div>
                    </div>

                    <!-- Transfer Request Form -->
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>Transfer Request Form
                            </h4>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <!-- Success Message (Hidden by default) -->
                            <div id="successMessage" class="alert alert-success d-none">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1">Request Submitted Successfully!</h5>
                                        <p class="mb-0" id="successText"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Error Message (Hidden by default) -->
                            <div id="errorMessage" class="alert alert-danger d-none">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle fa-2x me-3 text-danger"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1">Request Failed</h5>
                                        <p class="mb-0" id="errorText"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Request Warning (Hidden by default) -->
                            <div id="pendingWarning" class="alert alert-warning d-none">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1">Pending Request Exists</h5>
                                        <p class="mb-0" id="pendingText"></p>
                                    </div>
                                </div>
                            </div>

                            <form id="transferRequestForm" method="POST" action="{{ route('transfer.request.submit') }}">

                                @csrf

                                <div class="row">
                                    <!-- Current Team -->
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="from_team_id" class="form-label fw-bold">
                                                <i class="fas fa-user-friends me-1 text-primary"></i>Current Team <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-users text-muted"></i>
                                            </span>
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

                                    <!-- Destination Team -->
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="to_team_id" class="form-label fw-bold">
                                                <i class="fas fa-arrow-right me-1 text-primary"></i>
                                                Destination Team <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-flag text-muted"></i>
                                            </span>
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
                                </div>

                                <!-- Player Selection -->
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="player_id" class="form-label fw-bold">
                                            <i class="fas fa-user me-1 text-primary"></i>
                                            Player Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
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

                                <!-- Additional Notes -->
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="transfer_notes" class="form-label fw-bold">
                                            <i class="fas fa-sticky-note me-1 text-primary"></i>
                                            Additional Notes (Optional)
                                        </label>
                                        <textarea class="form-control" id="transfer_notes" name="transfer_notes" rows="4" placeholder="Please provide any additional information or reasons for your transfer request..." maxlength="500"></textarea>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">
                                                This will help the team manager understand your request
                                            </small>
                                            <small class="text-muted">
                                                <span id="charCount">0</span>/500 characters
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Information Alert -->
                                <div class="alert alert-light border mb-4">
                                    <div class="d-flex">
                                        <i class="fas fa-envelope fa-lg text-primary me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-2">Email Notification</h6>
                                            <p class="mb-0 small">
                                                After submitting your request, confirmation emails will be sent to:
                                            </p>
                                            <ul class="mb-0 small">
                                                <li>Your registered email address</li>
                                                <li>Team manager of both current and destination teams</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                                        <i class="fas fa-redo me-1"></i> Clear Form
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="submitBtn">
                                        <i class="fas fa-paper-plane me-1"></i> Submit Transfer Request
                                    </button>
                                </div>
                            </form>

                            <!-- Form Guidelines -->
                            <div class="mt-5 pt-4 border-top">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-question-circle me-2 text-primary"></i>
                                    Transfer Request Guidelines
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Only one pending request per player
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Review within 3-5 business days
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Email notifications sent upon submission
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Team automatically updated if approved
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-0">
                            Need help? Contact the team manager at
                            <a href="mailto:manager@example.com" class="text-decoration-none">manager@example.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection