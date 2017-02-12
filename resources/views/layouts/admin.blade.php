@extends('layouts.app')
@section('extra_heads')
    <style type="text/css">
        body {
            padding-top: 50px;
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
                <form class="navbar-form navbar-left hidden-sm">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                        </span>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('admin.persons')}}">IDP Records</a></li>
                    <li><a href="{{route('admin.camps')}}">Camps</a></li>
                    <li><a href="{{route('admin.organizations')}}">Organizations</a></li>
                    <li><a href="{{route('admin.users')}}">Users</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            More &hellip; <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('admin.locations_states')}}">Locations</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('admin.sys_log')}}">Sys. Logs</a></li>
                            <li><a href="{{route('admin.settings')}}">App. Settings</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <span class="hidden-lg hidden-md hidden-sm">My Account</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('account.profile')}}">Update Profile</a></li>
                            <li><a href="{{route('account.password')}}">Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            @if(is_object($user = Auth::user()) and $user->isDeo())
                                <li><a href="{{route('deo.dashboard')}}">DEO Dashboard</a></li>
                            @endif
                            <li><a href="#" id="logout-button">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="sh-100vh">
        @yield('content')
    </div>
    @include('parts.navbar-footer')
@endsection