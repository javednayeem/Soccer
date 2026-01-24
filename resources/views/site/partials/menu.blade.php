<div class="ml-auto">
    <nav class="site-navigation position-relative text-right" role="navigation" style="z-index: 10">
        <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">

            <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="{{ request()->routeIs('matches.schedule') ? 'active' : '' }}"><a href="{{ route('matches.schedule') }}" class="nav-link">Schedule</a></li>
{{--            <li class="{{ request()->routeIs('matches.standing') ? 'active' : '' }}"><a href="{{ route('matches.standing') }}" class="nav-link">Standing</a></li>--}}

            <li class="has-children">
                <a href="#" class="nav-link">Matches</a>
                <ul class="dropdown">

                    <li class="{{ request()->routeIs('matches.schedule') ? 'active' : '' }}">
                        <a href="{{ route('matches.schedule') }}" class="nav-link">Schedule</a>
                    </li>

                    <li class="{{ request()->routeIs('matches.result') ? 'active' : '' }}">
                        <a href="{{ route('matches.result') }}" class="nav-link">Result</a>
                    </li>

                    <li class="{{ request()->routeIs('matches.standing') ? 'active' : '' }}">
                        <a href="{{ route('matches.standing') }}" class="nav-link">Standing</a>
                    </li>

                    {{--<li class="{{ request()->routeIs('matches.player') ? 'active' : '' }}">--}}
                    {{--<a href="{{ route('matches.player') }}" class="nav-link">Player</a>--}}
                    {{--</li>--}}

                    <li class="{{ request()->routeIs('top.scorers') ? 'active' : '' }}">
                        <a href="{{ route('top.scorers') }}" class="nav-link">Top Scorers</a>
                    </li>

                    <li class="{{ request()->routeIs('matches.standing') ? 'active' : '' }}">
                        <a href="{{ route('matches.standing') }}" class="nav-link">Standing</a>
                    </li>

                </ul>
            </li>

            {{--<li class="{{ request()->routeIs('top.scorers') ? 'active' : '' }}"><a href="{{ route('top.scorers') }}" class="nav-link">Top Scorers</a></li>--}}
{{--            <li class="{{ request()->routeIs('matches.player') ? 'active' : '' }}"><a href="{{ route('matches.player') }}" class="nav-link">Player</a></li>--}}
            <li class="{{ request()->routeIs('event') ? 'active' : '' }}"><a href="{{ route('event') }}" class="nav-link">News</a></li>

            @guest

            {{--<li class="{{ request()->routeIs('player.registration') ? 'active' : '' }}">--}}
            {{--<a href="{{ route('player.registration') }}" class="nav-link">Player Registration</a>--}}
            {{--</li>--}}

            {{--<li class="{{ request()->routeIs('transfer.request.form') ? 'active' : '' }}">--}}
            {{--<a href="{{ route('transfer.request.form') }}" class="nav-link">Team Transfer Request</a>--}}
            {{--</li>--}}


            <li class="has-children">
                <a href="#" class="nav-link">Player Services</a>
                <ul class="dropdown">

                    <li class="{{ request()->routeIs('matches.player') ? 'active' : '' }}">
                        <a href="{{ route('matches.player') }}" class="nav-link">Player</a>
                    </li>

                    <li class="{{ request()->routeIs('player.registration') ? 'active' : '' }}">
                        <a href="{{ route('player.registration') }}" class="nav-link">Player Registration</a>
                    </li>

                    <li class="{{ request()->routeIs('transfer.request.form') ? 'active' : '' }}">
                        <a href="{{ route('transfer.request.form') }}" class="nav-link">Team Transfer Request</a>
                    </li>

                </ul>
            </li>

            <li class="{{ request()->routeIs('login') ? 'active' : '' }}">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
            </li>

            @endguest
        </ul>
    </nav>

    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white">
        <span class="icon-menu h3 text-white"></span>
    </a>
</div>
