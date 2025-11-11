<div class="ml-auto">
    <nav class="site-navigation position-relative text-right" role="navigation">
        <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="{{ request()->routeIs('match') ? 'active' : '' }}"><a href="{{ route('match') }}" class="nav-link">Matches</a></li>
            <li class="{{ request()->routeIs('player') ? 'active' : '' }}"><a href="{{ route('player') }}" class="nav-link">Players</a></li>
            <li class="{{ request()->routeIs('blog') ? 'active' : '' }}"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
        </ul>
    </nav>

    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white">
        <span class="icon-menu h3 text-white"></span>
    </a>
</div>
