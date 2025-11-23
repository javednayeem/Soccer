<header class="site-navbar py-4" role="banner">

    <div class="container">
        <div class="d-flex align-items-center">
            <div class="site-logo">
                <a href="/">
                    <img src="/site/images/logo.png" alt="Logo">
                </a>
            </div>

            @include('site.partials.menu')

        </div>
    </div>

</header>

@if(Route::current()->getName() == 'home')

    <div class="hero overlay" style="background-image: url('{{ asset('site/images/bg_3.jpg') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 ml-auto">
                    <h1 class="text-white">@yield('title')</h1>
                    <p>@yield('subtitle')</p>
                    <div id="date-countdown" class="pb-1" data-countdown="{{ $activeLeague->start_date->format('Y/m/d 00:00:00') }}"></div>
                </div>
            </div>
        </div>
    </div>

@elseif(!in_array(Route::current()->getName(), ['login', 'team.registration', 'team.store', 'player.registration', 'player.store']))

    <div class="hero overlay" style="background-image: url('{{ asset('site/images/bg_3.jpg') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="text-white">@yield('title')</h1>
                    <p>@yield('subtitle')</p>
                </div>
            </div>
        </div>
    </div>

@endif
