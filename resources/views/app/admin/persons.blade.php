@extends('layouts.admin');
@section('content')
    <div class="container">
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
                                <li><a href="#">Delete</a></li>
                                <li><a href="#">Restore</a></li>
                                <li><a href="#">Delete Permanently</a></li>
                            </ul>
                        </div>
                    </span>
                </h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Code</th>
                    <th>Names</th>
                    <th width="5%">Sex</th>
                    <th width="10%">Age</th>
                    <th width="5%">Height</th>
                    <th width="8%">Relations</th>
                    <th width="5%">&hellip;</th>
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
                        <td>---</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="8" class="text-center">{{$persons->links()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection