@extends('layouts.site')
@section('content')

    <div class="site-section reg-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="reg-header">
                        <span class="reg-eyebrow">Winter League</span>
                        <h1>Player Registration</h1>
                        <p>Fill in your details below to join your team's squad.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert reg-alert alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="reg-card">
                        <div class="reg-card-body">
                            <form action="{{ route('player.store') }}" method="POST" enctype="multipart/form-data" id="playerForm">
                                @csrf

                                {{-- 1. Personal --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">1</span>Personal Information</div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name" class="reg-label">First Name <span class="req">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name" class="reg-label">Last Name <span class="req">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="reg-label">Email <span class="req">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="player@example.com" required>
                                                @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_no" class="reg-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{ old('phone_no') }}" placeholder="+358123456789">
                                                @error('phone_no')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nationality" class="reg-label">Nationality <span class="req">*</span></label>
                                                <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality') }}" required>
                                                @error('nationality')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_of_birth" class="reg-label">Date of Birth <span class="req">*</span></label>
                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                                @error('date_of_birth')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Team & position --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">2</span>Team &amp; Position</div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="team_id" class="reg-label">Team <span class="req">*</span></label>
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="position" class="reg-label">Position <span class="req">*</span></label>
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
                                                <label for="jersey_number" class="reg-label">Jersey Number</label>
                                                <input type="number" class="form-control" id="jersey_number" name="jersey_number" value="{{ old('jersey_number') }}" min="1" max="99" placeholder="1 - 99">
                                                @error('jersey_number')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. Physical --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">3</span>Physical Details</div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="height" class="reg-label">Height (meters)</label>
                                                <input type="number" step="0.01" class="form-control" id="height" name="height" value="{{ old('height') }}" min="1.50" max="2.20" placeholder="1.75">
                                                @error('height')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="weight" class="reg-label">Weight (kg)</label>
                                                <input type="number" step="0.1" class="form-control" id="weight" name="weight" value="{{ old('weight') }}" min="40" max="120" placeholder="70.5">
                                                @error('weight')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. Photo --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">4</span>Player Photo</div>

                                    <div class="form-group">
                                        <label class="photo-drop" for="photo">
                                            <div class="photo-preview" id="photoPreview"><span>&#128100;</span></div>
                                            <div class="photo-text">
                                                <strong id="photoName">Click to upload a photo</strong>
                                                <span>Optional &middot; JPG or PNG &middot; max 2MB</span>
                                            </div>
                                            <input type="file" id="photo" name="photo" accept="image/*">
                                        </label>
                                        @error('photo')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Rules Agreement Checkbox --}}
                                <div class="form-group">
                                    <div class="rules-box">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="agree_rules" name="agree_rules" value="1" {{ old('agree_rules') ? 'checked' : '' }} required>
                                            <label class="custom-control-label" for="agree_rules">
                                                I have read, understood, and agree to abide by all Winter League rules and regulations as a condition of my registration and participation. I am also agreed to accept any punishment from management team for not following the rules.
                                            </label>
                                        </div>
                                    </div>
                                    @error('agree_rules')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" id="registerBtn" class="btn btn-primary btn-block py-3 reg-submit" disabled>Register Player</button>
                                </div>

                                <div class="reg-footnote">
                                    <span class="text-danger">*</span> Required fields
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkbox = document.getElementById('agree_rules');
        var registerBtn = document.getElementById('registerBtn');

        function toggleButton() {
            registerBtn.disabled = !checkbox.checked;
        }

        // Set initial state (important if old('agree_rules') was checked)
        toggleButton();

        // Listen for changes
        checkbox.addEventListener('change', toggleButton);

        // Photo preview
        var photoInput = document.getElementById('photo');
        var photoPreview = document.getElementById('photoPreview');
        var photoName = document.getElementById('photoName');

        photoInput.addEventListener('change', function () {
            var file = photoInput.files && photoInput.files[0];

            if (!file) {
                photoPreview.style.backgroundImage = '';
                photoPreview.classList.remove('has-image');
                photoName.textContent = 'Click to upload a photo';
                return;
            }

            photoName.textContent = file.name;

            var reader = new FileReader();
            reader.onload = function (e) {
                photoPreview.style.backgroundImage = 'url(' + e.target.result + ')';
                photoPreview.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
