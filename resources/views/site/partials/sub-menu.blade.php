@if(request()->routeIs('matches.schedule') || request()->routeIs('matches.result') || request()->routeIs('matches.standing') ||request()->routeIs('matches.player'))
    <div class="sub-menu-bar">
        <div class="container">
            <ul class="sub-menu">

                <li class="{{ request()->routeIs('matches.schedule') ? 'active' : '' }}">
                    <a href="{{ route('matches.schedule') }}">Schedule</a>
                </li>

                <li class="{{ request()->routeIs('matches.result') ? 'active' : '' }}">
                    <a href="{{ route('matches.result') }}">Results</a>
                </li>

                <li class="{{ request()->routeIs('matches.standing') ? 'active' : '' }}">
                    <a href="{{ route('matches.standing') }}">Standings</a>
                </li>

                <li class="{{ request()->routeIs('matches.player') ? 'active' : '' }}">
                    <a href="{{ route('matches.player') }}">Players</a>
                </li>

            </ul>
        </div>
    </div>
@endif