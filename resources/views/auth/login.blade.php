@extends('layouts.site')
@section('title', 'Login to Your Account')

@section('content')

    <style>

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .site-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .site-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .footer-section {
            margin-top: auto;
            background-color: #343a40;
            color: white;
            padding: 1.5rem 0;
        }

        .bg-light {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Make labels more visible */
        .text-white {
            color: #fff !important;
            font-weight: 600;
        }

        /* Improve button styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>

    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-light p-5 rounded">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-white">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-white">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block py-3">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
