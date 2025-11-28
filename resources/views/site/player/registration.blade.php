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
                        <form action="{{ route('player.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="text-white">First Name *</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="text-white">Last Name *</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="team_id" class="text-white">Team *</label>
                                <select class="form-control" id="team_id" name="team_id" required>
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                @error('team_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no" class="text-white">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{ old('phone_no') }}" placeholder="+358123456789">
                                        @error('phone_no')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="text-white">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="player@example.com" required>
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position" class="text-white">Position *</label>
                                        <select class="form-control" id="position" name="position" required>
                                            <option value="">Select Position</option>
                                            <option value="Goalkeeper" {{ old('position') == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                                            <option value="Defender" {{ old('position') == 'Defender' ? 'selected' : '' }}>Defender</option>
                                            <option value="Midfielder" {{ old('position') == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                                            <option value="Forward" {{ old('position') == 'Forward' ? 'selected' : '' }}>Forward</option>
                                        </select>
                                        @error('position')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jersey_number" class="text-white">Jersey Number</label>
                                        <input type="number" class="form-control" id="jersey_number" name="jersey_number" value="{{ old('jersey_number') }}" min="1" max="99">
                                        @error('jersey_number')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationality" class="text-white">Nationality *</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality') }}" required>
                                        @error('nationality')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_of_birth" class="text-white">Date of Birth *</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                        @error('date_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="height" class="text-white">Height (meters)</label>
                                        <input type="number" step="0.01" class="form-control" id="height" name="height" value="{{ old('height') }}" min="1.50" max="2.20" placeholder="1.75">
                                        @error('height')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="weight" class="text-white">Weight (kg)</label>
                                        <input type="number" step="0.1" class="form-control" id="weight" name="weight" value="{{ old('weight') }}" min="40" max="120" placeholder="70.5">
                                        @error('weight')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="photo" class="text-white">Player Photo</label>
                                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                                <small class="form-text text-muted">Optional: Upload player photo (max 2MB)</small>
                                @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block py-3">Register Player</button>
                            </div>

                            <div class="text-center">
                                <small class="text-muted">* Required fields</small>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection