@extends('layouts.site')
@section('title', 'Login to Your Account')


@section('content')

    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-light p-5 rounded">
                        <form action="#" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-dark">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-dark">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label text-dark" for="remember">Remember me</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block py-3">Login</button>
                            </div>
                            <div class="text-center">
                                <a href="#" class="text-dark">Forgot your password?</a>
                            </div>
                            <div class="text-center mt-3">
                                <span class="text-dark">Don't have an account? </span>
                                <a href="register.html" class="text-primary">Sign up here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection