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
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-admin-top"
                        aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('app.home')}}">{{config('app.name')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-admin-top">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{route('app.home')}}">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="glyphicon glyphicon-home"></span>
                        </a>
                    </li>
                    <li><a href="{{route('account.profile')}}">Update Profile</a></li>
                    <li><a href="{{route('account.password')}}">Change Password</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" id="logout-button">Logout</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="sh-100vh">
        @yield('content')
    </div>
    @include('parts.navbar-footer')
@endsection