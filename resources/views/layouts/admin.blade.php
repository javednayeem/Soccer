<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('scoreboard.partials.meta')

    @include('scoreboard.partials.pre-scripts')
</head>

<body class="game_info" data-spy="scroll" data-target=".header">

{{--<div id="preloader">--}}
    {{--<img class="preloader" src="{{ env('APP_PATH') }}/images/loading-img.gif" alt="">--}}
    {{--<img class="preloader" src="{{ env('APP_PATH') }}/images/favicon.ico" alt="">--}}
{{--</div>--}}

@include('scoreboard.partials.header')

@yield('content')

@include('scoreboard.partials.footer')

@include('scoreboard.partials.post-scripts')

</body>
</html>