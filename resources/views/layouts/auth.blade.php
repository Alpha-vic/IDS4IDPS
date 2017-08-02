@extends('layouts.app')
@section('extra_heads')
    <style type="text/css">
        body {
            padding-top: 70px;
        }
    </style>
@endsection
@section('body')
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#auth-navbar"
                        aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('app.home')}}">{{config('app.name')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="auth-navbar">
                @if(!Auth::guest())
                    @include('parts.main-nav.deo')
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{route('app.home')}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="{{route('auth.login')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div style="min-height: calc(100vh - 120px)">
        @yield('content')
    </div>
    @include('parts.navbar-footer')
@endsection
