@extends('layouts.site')
@section('content')

    <div class="site-section reg-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="reg-header">
                        <span class="reg-eyebrow">Winter League</span>
                        <h1>Team Registration</h1>
                        <p>Register your team for the league. An admin will review and approve it.</p>
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
                            <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data" id="teamForm">
                                @csrf

                                {{-- 1. Team --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">1</span>Team Information</div>

                                    <div class="form-group">
                                        <label for="name" class="reg-label">Team Name <span class="req">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter team name" required>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 2. Manager --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">2</span>Team Manager</div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="team_manager" class="reg-label">Manager Name <span class="req">*</span></label>
                                                <input type="text" class="form-control" id="team_manager" name="team_manager" value="{{ old('team_manager') }}" placeholder="Manager's full name" required>
                                                @error('team_manager')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="manager_phone" class="reg-label">Manager Phone</label>
                                                <input type="tel" class="form-control" id="manager_phone" name="manager_phone" value="{{ old('manager_phone') }}" placeholder="Phone number">
                                                @error('manager_phone')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="manager_email" class="reg-label">Manager Email <span class="req">*</span></label>
                                                <input type="email" class="form-control" id="manager_email" name="manager_email" value="{{ old('manager_email') }}" placeholder="Manager email address" required>
                                                @error('manager_email')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. Images --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">3</span>Team Images</div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="reg-label" for="logo">Team Logo</label>
                                                <label class="photo-drop" for="logo">
                                                    <div class="photo-preview rounded-square" data-preview><span>&#9917;</span></div>
                                                    <div class="photo-text">
                                                        <strong data-name>Upload logo</strong>
                                                        <span>200x200px &middot; PNG/JPG</span>
                                                    </div>
                                                    <input type="file" id="logo" name="logo" accept="image/*">
                                                </label>
                                                @error('logo')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="reg-label" for="team_image">Team Photo</label>
                                                <label class="photo-drop" for="team_image">
                                                    <div class="photo-preview rounded-square" data-preview><span>&#128247;</span></div>
                                                    <div class="photo-text">
                                                        <strong data-name>Upload photo</strong>
                                                        <span>Team group photo (optional)</span>
                                                    </div>
                                                    <input type="file" id="team_image" name="team_image" accept="image/*">
                                                </label>
                                                @error('team_image')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. Additional --}}
                                <div class="reg-section">
                                    <div class="reg-section-title"><span class="reg-step">4</span>Additional Details</div>

                                    <div class="form-group">
                                        <label for="payment_reference_number" class="reg-label">Payment Reference Number</label>
                                        <input type="text" class="form-control" id="payment_reference_number" name="payment_reference_number" value="{{ old('payment_reference_number') }}" placeholder="If payment already made">
                                        @error('payment_reference_number')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="note" class="reg-label">Additional Notes</label>
                                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Any additional information">{{ old('note') }}</textarea>
                                        @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-block py-3 reg-submit">Register Team</button>
                                </div>

                                <div class="reg-footnote">
                                    <span class="text-danger">*</span> Required fields. Team will be approved by admin after registration.
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
        document.querySelectorAll('.photo-drop').forEach(function (drop) {
            var input = drop.querySelector('input[type="file"]');
            var preview = drop.querySelector('[data-preview]');
            var name = drop.querySelector('[data-name]');
            var defaultName = name.textContent;

            input.addEventListener('change', function () {
                var file = input.files && input.files[0];

                if (!file) {
                    preview.style.backgroundImage = '';
                    preview.classList.remove('has-image');
                    name.textContent = defaultName;
                    return;
                }

                name.textContent = file.name;

                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.style.backgroundImage = 'url(' + e.target.result + ')';
                    preview.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>
@endpush
