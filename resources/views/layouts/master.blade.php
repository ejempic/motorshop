<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Motorshop | @yield('title')</title>
{{--    <title>Trace | @yield('title')</title>--}}

{{--    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('/favicon_io/apple-touch-icon.png') }}">--}}
{{--    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/favicon_io/favicon-32x32.png') }}">--}}
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/favicon_io/favicon-16x16.png') }}">--}}
{{--    <link rel="manifest" href="{{ URL::to('/favicon_io/site.webmanifest') }}">--}}

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/css/template/animate.css">
    <link rel="stylesheet" href="/css/template/style.css">

{{--    {!! Html::style('/css/app.css') !!}--}}
    {!! Html::style('/css/styles.css') !!}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('/css/template/animate.css') !!}





    @yield('styles')

</head>

<body class="pace-done">

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">

                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="/img/blank-profile.jpg" style="width: 48px;"/>
{{--                        <img alt="image" class="rounded-circle profile-pic" src="{{ authProfilePic(Auth::user()->id) }}"/>--}}
                        {{--<img alt="image" class="rounded-circle profile-pic" src="/img/blank-profile.jpg"/>--}}
{{--                        <img alt="image" class="img-fluid" src="{{ asset('img/a1.jpg') }}"/>--}}

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{auth()->user()->name}}</span>
                            <span class="text-muted text-xs block"> Admin <b class="caret"></b></span>
                        </a>
                        <div style="position: relative">
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
{{--                            <li class="dropdown-divider"></li>--}}
{{--                            <li><a class="dropdown-item btn-logout" href="#" id="">Logout</a></li>--}}
                        </ul>
                        </div>
                    </div>
                    <div class="logo-element">
                        Motor
                    </div>
                </li>

                @include('layouts.menu')

            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">

        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                    {{-- slot for search bar --}}

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"><strong class="text-mams-blue">Welcome</strong> <strong class="text-mams-gray">to</strong> <strong class="text-mams-red">{!! config('app.name') !!}</strong>.</span>
                    </li>

                    {{-- slot for mail notification --}}

                    {{-- slot for general notification --}}

                    <li>
                        <a href="{{route('logout')}}" > <i class="fa fa-sign-out"></i> Log out </a>
                    </li>
                </ul>

            </nav>
        </div>

{{--        @include('flash::message')--}}

        <div id="app">
            @yield('content')
        </div>

        <div class="footer">
            <div class="float-right">
                <strong></strong>
            </div>
            <div>
                <strong>Copyright</strong>
                <strong></strong>
            </div>
        </div>

    </div>
{{--    {{ Form::open(array('route' => 'logout', 'class' => 'sr-only', 'id' => 'form-logout')) }}--}}
{{--    @csrf--}}
{{--    {{ Form::close() }}--}}
</div>

<!-- Mainly scripts -->
{{--<script src="/js/app.js"></script>--}}
{!! Html::script('/js/app.js') !!}
{!! Html::script('/js/template/popper.min.js') !!}
{!! Html::script('/js/template/bootstrap.js') !!}
{!! Html::script('/js/template/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}

<!-- Custom and plugin javascript -->
{!! Html::script('/js/template/inspinia.js') !!}
{!! Html::script('/js/template/plugins/pace/pace.min.js') !!}

@yield('scripts')

{{--{!! Html::script('/js/template/jquery-3.1.1.min.js') !!}--}}
<!-- Custom and plugin javascript -->
{{--<script src="/js/template/inspinia.js"></script>--}}


</body>
</html>
