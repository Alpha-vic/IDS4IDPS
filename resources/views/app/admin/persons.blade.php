@extends('layouts.admin')
@section('content')
    <div class="container">
        <form action="{{route('idp.manage_list')}}" method="post" id="manageList" onsubmit="return false;">
            <input name="action" value="" type="hidden">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        Int. Displaced Persons
                        <span class="pull-right">
                        <!-- Split button -->
                        <div class="btn-group btn-group-sm">
                            <a href="{{route('app.enroll_idp')}}" class="btn btn-primary">New IDP Record</a>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                &nbsp;<span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="disabled small">with selected...</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <button type="submit" value="delete" class="btn-link">Delete</button>
                                </li>
                                <li>
                                    <button type="submit" value="restore" class="btn-link">Restore</button>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <button type="submit" value="discard" class="btn-link">Delete Permanently</button>
                                </li>
                            </ul>
                        </div>
                    </span>
                    </h2>
                </div>
            </div>
            <div class="text-center padding-1em"><span id="notify"></span></div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Code</th>
                        <th>Names</th>
                        <th width="5%">Sex</th>
                        <th width="10%">Age</th>
                        <th width="5%">Height(ft.)</th>
                        <th width="8%">Relations</th>
                        <th width="3%"><input type="checkbox" class="toggle-btn" data-toggle="input.togglable"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sn = startSN($persons); ?>
                    @foreach($persons as $person)
                        <tr @if($person->trashed()) class="warning" @endif >
                            <td>{{$sn++}}</td>
                            <td>{{$person->code}}</td>
                            <td>{{$person->name()}}</td>
                            <td>{{$person->sex}}</td>
                            <td>{{$person->age}}</td>
                            <td>{{$person->height}}</td>
                            <td>--</td>
                            <td><input name="id[]" type="checkbox" value="{{$person->id}}" class="togglable"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8" class="text-center">{{$persons->links()}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
@section('extra_scripts')
    <script type="text/javascript" src="{{asset('js/app.list-manager.js')}}"></script>
@endsection