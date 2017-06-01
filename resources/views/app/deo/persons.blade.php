@extends('layouts.deo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Int. Displaced Persons
                    <span class="pull-right">
                        <!-- Split button -->
                        <span class="btn-group btn-group-sm">
                            <a href="{{route('deo.enroll_idp')}}" class="btn btn-primary">Enroll New IDP</a>
                        </span>
                    </span>
                </h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Code</th>
                    <th>Names</th>
                    <th width="5%">Sex</th>
                    <th width="10%">Age</th>
                    <th width="5%">Height</th>
                    <th width="8%">&hellip;</th>
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
                        <td><a  href="{{route('deo.verify_idp',['id'=>$person->id])}}" class="btn btn-sm btn-primary">Verify</a></td>
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