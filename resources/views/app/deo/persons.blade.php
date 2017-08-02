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
        <div class="row">
            <div class="col-md-8">
                @if(is_object($camp))
                    <strong>Camp: {{$camp->name}}</strong>
                @else
                    <strong>All Camps</strong>
                @endif
            </div>
            <div class="col-md-4">
                <form method="GET" id="campSelector" class="form-horizontal">
                    <div class="form-group-sm">
                        <div class="col-xs-9">
                            <select name="camp" class="form-control">
                                <option>--select camp--</option>
                                @foreach($camps as $c)
                                    <option value="{{$c->id}}"
                                            @if(is_object($camp) && $camp->id == $c->id) selected @endif
                                    >{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <input type="submit" value="Filter" class="btn btn-default">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="4%">#</th>
                    <th width="15%">Passport</th>
                    <th>Bio</th>
                    <th>Origin</th>
                    <th width="8%">&hellip;</th>
                </tr>
                </thead>
                <tbody>
                <?php $sn = startSN($persons); ?>
                @foreach($persons as $person)
                    <tr @if($person->trashed()) class="warning" @endif >
                        <td>{{$sn++}}</td>
                        <td><img src="{{$person->photoUrl}}" class="img-responsive"></td>
                        <td>
                            Name: {{$person->name()}}.<br/>
                            Sex: {{$person->sex}}<br/>
                            Age: {{$person->age}}<br/>
                            Height: {{$person->height}}
                        </td>
                        <td>
                            State: {{$person->state->name}}<br/>
                            LGA: {{$person->lga->name}}
                        </td>
                        <td><a href="{{route('deo.verify_idp',['id'=>$person->id])}}" class="btn btn-sm btn-primary">Verify</a>
                        </td>
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