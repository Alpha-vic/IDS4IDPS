@extends('layouts.deo')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dashboard</h3>
            </div>
            <div class="panel-body">
                <div class="row text-center well well-sm">
                    <div class="col-xs-12 col-sm-6 col-md-3 img-thumbnail blue darken-3">
                        <a class="btn-link no-decoration white-text" href="{{route('deo.enroll_idp')}}">
                            <h5 class="bold small">
                                <span class="glyphicon glyphicon-plus"></span>
                            </h5>
                            <h3 class="money">Enroll new IDP</h3>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 img-thumbnail blue darken-3">
                        <a class="btn-link no-decoration white-text" href="{{route('deo.persons')}}">
                            <h5 class="bold small">View IDP Records by Camp</h5>
                            <h3 class="money">{{$idps}}</h3>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 img-thumbnail blue darken-3">
                        <a class="btn-link no-decoration white-text" href="{{route('deo.camps')}}">
                            <h5 class="bold small">View IDP Camps</h5>
                            <h3 class="money">{{$camps}}</h3>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 img-thumbnail blue darken-3">
                        <a class="btn-link no-decoration white-text" href="{{route('deo.organizations')}}">
                            <h5 class="bold small">Supporting NGOs</h5>
                            <h3 class="money">{{$organizations}}</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection