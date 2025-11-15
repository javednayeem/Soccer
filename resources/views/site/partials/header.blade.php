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

    <div class="hero overlay" style="background-image: url('site/images/bg_3.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 ml-auto">
                    <h1 class="text-white">@yield('title')</h1>
                    <p>@yield('subtitle')</p>
                    <div id="date-countdown"></div>
                    {{--<p>--}}
                    {{--<a href="#" class="btn btn-primary py-3 px-4 mr-3">Book Ticket</a>--}}
                    {{--<a href="#" class="more light">Learn More</a>--}}
                    {{--</p>--}}
                </div>
            </div>
        </div>
    </div>

@elseif(!in_array(Route::current()->getName(), ['login', 'team.registration', 'team.store', 'player.registration', 'player.store']))

    <div class="hero overlay" style="background-image: url('site/images/bg_3.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mx-auto text-center">
                    <h1 class="text-white">@yield('title')</h1>
                    <p>@yield('subtitle')</p>
                </div>
            </div>
        </div>
    </div>

@endif
