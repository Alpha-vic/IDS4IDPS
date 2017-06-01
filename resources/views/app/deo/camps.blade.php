@extends('layouts.deo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">IDP Camps</h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Code</th>
                    <th>Name</th>
                    <th width="25%">Address</th>
                </tr>
                </thead>
                <tbody>
                <?php $sn = startSN($camps); ?>
                @foreach($camps as $camp)
                    <tr @if($camp->trashed()) class="warning" @endif >
                        <td>{{$sn++}}</td>
                        <td>{{$camp->code}}</td>
                        <td>{{$camp->name}}</td>
                        <td>{{$camp->address}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-center">{{$camps->links()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('extra_scripts')

@endsection