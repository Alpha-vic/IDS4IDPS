@extends('layouts.deo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">Support Organizations</h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Name</th>
                    <th width="20%">Email</th>
                    <th width="15%">Phone</th>
                </tr>
                </thead>
                <tbody>
                <?php $sn = startSN($organizations); ?>
                @foreach($organizations as $org)
                    <tr @if($org->trashed()) class="warning" @endif >
                        <td>{{$sn++}}</td>
                        <td>{{$org->name}}</td>
                        <td>{{$org->email}}</td>
                        <td>{{$org->phone}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-center">{{$organizations->links()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('extra_scripts')

@endsection