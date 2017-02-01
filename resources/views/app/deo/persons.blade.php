@extends('layouts.deo');
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Int. Displaced Persons
                    <span class="pull-right">
                        <!-- Split button -->
                        <span class="btn-group btn-group-sm">
                            <a href="{{route('app.enroll_idp')}}" class="btn btn-primary">Enroll New IDP</a>
                        </span>
                    </span>
                </h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Code</th>
                    <th>Names</th>
                    <th width="5%">Sex</th>
                    <th width="10%">Age</th>
                    <th width="5%">Height</th>
                    <th width="8%">Relations</th>
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
                        <td>---</td>
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