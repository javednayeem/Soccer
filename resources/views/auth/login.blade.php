@extends('layouts.site')
@section('title', 'Login to Your Account')

@section('content')

    <div class="login-section">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-10 col-xl-9">
                    <div class="login-card">
                        <div class="row no-gutters">

                            <!-- Brand panel -->
                            <div class="col-lg-5 d-none d-lg-flex login-brand">
                                <div class="login-brand-inner">
                                    <div class="login-ball">
                                        <svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polygon points="12 7.5 15.8 10.3 14.4 14.7 9.6 14.7 8.2 10.3" fill="currentColor" stroke="none" opacity=".9"/>
                                            <path d="M12 7.5V2.2M15.8 10.3l5.1-1.6M14.4 14.7l3.1 4.3M9.6 14.7l-3.1 4.3M8.2 10.3L3.1 8.7"/>
                                        </svg>
                                    </div>
                                    <h2>Welcome Back</h2>
                                    <p>Sign in to manage your team, track fixtures and follow every moment of the Bangladeshi Football League.</p>

                                    <ul class="login-points">
                                        <li><span></span> Live scores &amp; match updates</li>
                                        <li><span></span> Team &amp; player management</li>
                                        <li><span></span> League tables and statistics</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Form panel -->
                            <div class="col-lg-7">
                                <div class="login-form-wrap">
                                    <div class="login-heading">
                                        <span class="login-eyebrow">Bangladeshi Football League</span>
                                        <h1>Login to your account</h1>
                                        <p>Enter your credentials to access your dashboard.</p>
                                    </div>

                                    @if(session('success'))
                                        <div class="alert login-alert login-alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert login-alert login-alert-danger alert-dismissible fade show" role="alert">
                                            Invalid email or password. Please try again.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf

                                        <!-- Email -->
                                        <div class="login-field">
                                            <label for="email">Email address</label>
                                            <div class="login-input @error('email') is-invalid @enderror">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                                                <input type="email"
                                                       id="email"
                                                       name="email"
                                                       placeholder="you@example.com"
                                                       autocomplete="email"
                                                       required
                                                       autofocus
                                                       value="{{ old('email') }}">
                                            </div>
                                            @error('email')
                                            <small class="login-error">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="login-field">
                                            <label for="password">Password</label>
                                            <div class="login-input @error('password') is-invalid @enderror">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                                                <input type="password"
                                                       id="password"
                                                       name="password"
                                                       placeholder="Enter your password"
                                                       autocomplete="current-password"
                                                       required>
                                                <button type="button" class="login-toggle" id="togglePassword" aria-label="Show password" tabindex="-1">
                                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </div>
                                            @error('password')
                                            <small class="login-error">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <button type="submit" class="login-submit">
                                            <span>Login to Account</span>
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-section {
            position: relative;
            overflow: hidden;
            padding: 80px 0;
            background: linear-gradient(135deg, #f4f5f9 0%, #e9ecf4 100%);
        }

        .login-bg-shape {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .login-bg-shape-1 {
            width: 420px;
            height: 420px;
            top: -140px;
            right: -100px;
            background: radial-gradient(circle, rgba(238, 30, 70, .18), rgba(238, 30, 70, 0) 70%);
        }

        .login-bg-shape-2 {
            width: 380px;
            height: 380px;
            bottom: -140px;
            left: -100px;
            background: radial-gradient(circle, rgba(34, 40, 49, .16), rgba(34, 40, 49, 0) 70%);
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 60px -20px rgba(34, 40, 49, .35);
        }

        /* Brand panel */
        .login-brand {
            position: relative;
            background:
                radial-gradient(circle at 15% 10%, rgba(238, 30, 70, .35), transparent 45%),
                linear-gradient(160deg, #2b323d 0%, #222831 55%, #171b21 100%);
            color: #fff;
            padding: 48px 40px;
            align-items: center;
        }

        .login-brand::after {
            content: "";
            position: absolute;
            right: -70px;
            bottom: -70px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 36px solid rgba(255, 255, 255, .05);
        }

        .login-brand-inner {
            position: relative;
            z-index: 1;
        }

        .login-ball {
            width: 76px;
            height: 76px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            color: #fff;
            background: linear-gradient(135deg, #ee1e46, #c4102f);
            box-shadow: 0 12px 24px -8px rgba(238, 30, 70, .7);
        }

        .login-brand h2 {
            color: #fff;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .login-brand p {
            color: rgba(255, 255, 255, .7);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .login-points {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .login-points li {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, .88);
            font-size: 14px;
            margin-bottom: 14px;
        }

        .login-points li span {
            flex: 0 0 8px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 12px;
            background: #ee1e46;
            box-shadow: 0 0 0 4px rgba(238, 30, 70, .25);
        }

        /* Form panel */
        .login-form-wrap {
            padding: 56px 52px;
        }

        .login-eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #ee1e46;
            margin-bottom: 10px;
        }

        .login-heading h1 {
            font-size: 28px;
            font-weight: 700;
            color: #222831;
            margin-bottom: 8px;
        }

        .login-heading p {
            color: #7b8190;
            margin-bottom: 32px;
        }

        .login-field {
            margin-bottom: 22px;
        }

        .login-field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #222831;
            margin-bottom: 8px;
        }

        .login-input {
            display: flex;
            align-items: center;
            background: #f4f5f9;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 0 16px;
            color: #8a90a0;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease, color .2s ease;
        }

        .login-input:focus-within {
            background: #fff;
            border-color: #ee1e46;
            color: #ee1e46;
            box-shadow: 0 0 0 4px rgba(238, 30, 70, .12);
        }

        .login-input.is-invalid {
            border-color: #ee1e46;
            background: #fff;
        }

        .login-input svg {
            flex: 0 0 auto;
        }

        .login-input input {
            flex: 1;
            min-width: 0;
            height: 52px;
            padding: 0 12px;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: 15px;
            color: #222831 !important;
        }

        .login-input input::placeholder {
            color: #a9aebb;
        }

        .login-toggle {
            border: 0;
            background: transparent;
            padding: 6px;
            color: #8a90a0;
            cursor: pointer;
            line-height: 1;
            transition: color .2s ease;
        }

        .login-toggle:hover,
        .login-toggle.active {
            color: #ee1e46;
        }

        .login-error {
            display: block;
            margin-top: 6px;
            color: #ee1e46;
            font-size: 12.5px;
        }

        .login-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 54px;
            margin-top: 8px;
            border: 0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #ee1e46, #c4102f);
            box-shadow: 0 14px 24px -10px rgba(238, 30, 70, .8);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .login-submit svg {
            margin-left: 10px;
            transition: transform .2s ease;
        }

        .login-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 28px -10px rgba(238, 30, 70, .9);
        }

        .login-submit:hover svg {
            transform: translateX(4px);
        }

        .login-submit:focus {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(238, 30, 70, .25);
        }

        /* Alerts */
        .login-alert {
            border: 0;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 22px;
            padding: 12px 40px 12px 16px;
        }

        .login-alert-danger {
            background: #fdecef;
            color: #b3102d;
            border-left: 4px solid #ee1e46;
        }

        .login-alert-success {
            background: #eaf6ec;
            color: #1f7a33;
            border-left: 4px solid #2fb44e;
        }

        @media (max-width: 991.98px) {
            .login-section {
                padding: 40px 0;
            }
        }

        @media (max-width: 575.98px) {
            .login-form-wrap {
                padding: 36px 24px;
            }

            .login-heading h1 {
                font-size: 24px;
            }
        }
    </style>

@endsection

@push('scripts')
    <script>
        (function () {
            var toggle = document.getElementById('togglePassword');
            var input = document.getElementById('password');

            toggle.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                toggle.classList.toggle('active', show);
                toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
@endpush
