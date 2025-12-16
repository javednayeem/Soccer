<div class="left-side-menu">
    <div class="slimscroll-menu">
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                @if(Auth::user()->role == 'admin')
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="mdi mdi-view-dashboard mr-1"></i><span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.league') }}">
                            <i class="mdi mdi-podium mr-1"></i><span>Leagues</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.match') }}">
                            <i class="mdi mdi-swim mr-1"></i><span>Match</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.team') }}">
                            <i class="mdi mdi-account-group mr-1"></i><span>Teams</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.player') }}">
                            <i class="mdi mdi-swim mr-1"></i><span>Players</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="mdi mdi-soccer mr-1"></i><span>Live Score</span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('admin.live.matches') }}">Live Matches</a></li>
                            <li><a href="{{ route('admin.finished.matches') }}">Update Finished</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:void(0);">
                            <i class="mdi mdi-home-currency-usd"></i>
                            <span>Contributions</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('insert.contribution') }}">Insert Contribution</a></li>
                            <li><a href="{{ route('view.contribution.layout') }}">View Contribution</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('admin.user') }}">
                            <i class="mdi mdi-account-details mr-1"></i><span>Users</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fe-power mr-1 text-danger"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
