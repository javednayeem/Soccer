@extends('layouts.site')
@section('title', 'Login to Your Account')

@section('content')

    <div class="site-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-primary text-white text-center py-4">
                            <h3 class="mb-0">
                                <i class="mdi mdi-login mr-2"></i>
                                Login to Your Account
                            </h3>
                            <p class="mb-0 mt-2 opacity-75">Access your dashboard and manage your account</p>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <!-- Email Field -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="mdi mdi-email-outline me-2"></i>
                                        Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="mdi mdi-account text-muted"></i>
                                        </span>
                                        <input type="email"
                                               class="form-control border-start-0 ps-0"
                                               id="email"
                                               name="email"
                                               placeholder="Enter your email address"
                                               required
                                               value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="mdi mdi-lock-outline me-2"></i>
                                        Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="mdi mdi-key text-muted"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 ps-0"
                                               id="password"
                                               name="password"
                                               placeholder="Enter your password"
                                               required>
                                        <span class="input-group-text bg-light border-start-0 cursor-pointer"
                                              onclick="togglePassword()"
                                              style="cursor: pointer;">
                                            <i class="mdi mdi-eye-outline" id="password-toggle"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Remember Me & Forgot Password -->


                                <!-- Submit Button -->
                                <div class="form-group mb-4">
                                    <button type="submit" class="btn btn-danger btn-lg w-100 py-3 fw-bold">
                                        <i class="mdi mdi-login mr-2"></i>
                                        Login to Account
                                    </button>
                                </div>

                                <!-- Error Messages -->
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                                        Invalid email or password. Please try again.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                            <!-- Success Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-circle-outline me-2"></i>
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                            </form>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
            border-bottom: none;
        }

        .input-group-text {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
        }

        .form-control {
            border: 1px solid #e3e6f0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-group.mb-4 {
            position: relative;
            overflow: visible !important;
        }

        .btn-primary {
            position: relative;
            z-index: 1;
        }



        .cursor-pointer {
            cursor: pointer;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.75rem 1rem !important;
                font-size: 1rem !important;
            }
        }
    </style>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('mdi-eye-outline');
                toggleIcon.classList.add('mdi-eye-off-outline');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('mdi-eye-off-outline');
                toggleIcon.classList.add('mdi-eye-outline');
            }
        }
    </script>

@endsection