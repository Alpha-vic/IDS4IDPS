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
    <li><a href="{{route('deo.persons')}}">IDP Records</a></li>
    <li><a href="{{route('deo.camps')}}">Camps</a></li>
    <li><a href="{{route('deo.organizations')}}">Organizations</a></li>
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
            @if(is_object($user = Auth::user()) and $user->isAdmin())
                <li><a href="{{route('admin.dashboard')}}">Go to ACP</a></li>
            @endif
            <li><a href="#" id="logout-button">Logout</a></li>
        </ul>
    </li>
</ul>
