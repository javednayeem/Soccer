<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.partials.meta')

    @include('admin.partials.pre-scripts')

</head>

<body>


<div id="wrapper">


    @include('admin.partials.topbar')

    @include('admin.partials.menu')


    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                @auth
                <input type="hidden" id="id" value="{{ Auth::user()->id }}">
                <input type="hidden" id="user_name" value="{{ Auth::user()->name }}">
                @endauth

                <input type="hidden" id="token" value="{{ csrf_token() }}">

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

                @include('admin.partials.page-title')

                @yield('content')

            </div>
        </div>

        @include('admin.partials.footer')

    </div>

</div>



<div class="rightbar-overlay"></div>

@include('admin.partials.post-scripts')

</body>

</html>