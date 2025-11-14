@extends('layouts.site')
@section('content')

    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="bg-light p-5 rounded">
                        <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="text-white">Team Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter team name" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="team_manager" class="text-white">Team Manager *</label>
                                <input type="text" class="form-control" id="team_manager" name="team_manager" value="{{ old('team_manager') }}" placeholder="Manager's full name" required>
                                @error('team_manager')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="manager_email" class="text-white">Manager Email *</label>
                                <input type="email" class="form-control" id="manager_email" name="manager_email" value="{{ old('manager_email') }}" placeholder="Manager email address" required>
                                @error('manager_email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="manager_phone" class="text-white">Manager Phone</label>
                                <input type="tel" class="form-control" id="manager_phone" name="manager_phone" value="{{ old('manager_phone') }}" placeholder="Phone number">
                                @error('manager_phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo" class="text-white">Team Logo</label>
                                        <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                                        <small class="form-text text-muted">Recommended: 200x200px, PNG/JPG</small>
                                        @error('logo')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="team_image" class="text-white">Team Photo</label>
                                        <input type="file" class="form-control-file" id="team_image" name="team_image" accept="image/*">
                                        <small class="form-text text-muted">Team group photo (optional)</small>
                                        @error('team_image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note" class="text-white">Additional Notes</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="Any additional information">{{ old('note') }}</textarea>
                                @error('note')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="payment_reference_number" class="text-white">Payment Reference Number</label>
                                <input type="text" class="form-control" id="payment_reference_number" name="payment_reference_number" value="{{ old('payment_reference_number') }}" placeholder="If payment already made">
                                @error('payment_reference_number')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block py-3">Register Team</button>
                            </div>

                            <div class="text-center">
                                <small class="text-muted">* Required fields. Team will be approved by admin after registration.</small>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection