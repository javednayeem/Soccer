<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('site.partials.meta')

    @include('site.partials.pre-scripts')

</head>

<body>

<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    @include('site.partials.header')

    @yield('content')

    @include('site.partials.footer')

</div>

@include('site.partials.post-scripts')

</body>

</html>