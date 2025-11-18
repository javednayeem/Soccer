@extends('layouts.admin')
@section('title', $user->name)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Profile Card -->
            <div class="col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block">
                            <img src="/admin/images/users/{{ $user->user_image }}"
                                 class="rounded-circle avatar-xxl img-thumbnail shadow"
                                 alt="profile-image"
                                 onerror="this.src='/admin/images/users/default_user.png'">
                            <span class="badge bg-success rounded-pill position-absolute bottom-0 end-0 p-2">
                            <i class="mdi mdi-check"></i>
                        </span>
                        </div>

                        <h4 class="mt-3 mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ ucfirst($user->role) }}</p>

                        @if($user->position != 'none')
                            <span class="badge bg-primary mb-3">{{ ucfirst($user->position) }}</span>
                        @endif

                        <div class="text-start mt-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-email-outline text-primary me-2"></i>
                                <span class="text-muted">{{ $user->email }}</span>
                            </div>

                            @if($user->phone)
                                <div class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-phone-outline text-primary me-2"></i>
                                    <span class="text-muted">{{ $user->phone }}</span>
                                </div>
                            @endif

                            @if($user->address)
                                <div class="d-flex align-items-start mb-3">
                                    <i class="mdi mdi-map-marker-outline text-primary me-2 mt-1"></i>
                                    <span class="text-muted">{{ Str::limit($user->address, 50) }}</span>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-calendar-check-outline text-primary me-2"></i>
                                <span class="text-muted">Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="mdi mdi-lock-reset me-1"></i>Change Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Profile Settings</h4>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-circle-outline me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#profile-info" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-account-circle-outline d-md-none d-block me-1"></i>
                                    <span class="d-none d-md-block">Profile Information</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="profile-info">
                                <form action="{{ route('profile.edit') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                                                <small class="text-muted">Email cannot be changed</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror"
                                                  id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user_image" class="form-label">Profile Picture</label>
                                                <input type="file" class="form-control @error('user_image') is-invalid @enderror"
                                                       id="user_image" name="user_image" accept="image/*"
                                                       onchange="previewImage(this, 'imagePreview')">
                                                @error('user_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Max file size: 5MB. Allowed formats: JPG, PNG, GIF, SVG</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img id="imagePreview" src="/admin/images/users/{{ $user->user_image }}"
                                                         class="rounded img-fluid shadow"
                                                         alt="Preview" style="max-height: 150px;">
                                                    @if($user->user_image != 'default_user.png')
                                                        <button type="button" onclick="removeProfilePicture()"
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                                title="Remove picture">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-content-save-outline me-1"></i>Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
