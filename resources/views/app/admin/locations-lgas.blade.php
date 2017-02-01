@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Locations - LGAs
                    <span class="pull-right">
                        <a class="btn btn-sm btn-default" href="{{route('admin.locations_states')}}">
                            <span class="glyphicon glyphicon-step-backward"></span> Back
                        </a>
                        <!-- Split button -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary">New Record</button>
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
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">LGA Code</th>
                    <th>Name</th>
                    <th width="5%">&hellip;</th>
                </tr>
                </thead>
                <tbody>
                @for($sn=1; $sn<15; ++$sn)
                    <tr>
                        <td>{{$sn}}</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection