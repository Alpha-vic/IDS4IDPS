@extends('layouts.deo');
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">IDP Camps</h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Code</th>
                    <th>Name</th>
                    <th width="25%">Address</th>
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
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newCampModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form onsubmit="return false;" id="newCampForm" action="{{route('camp.add')}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Add New IDP Camp</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="c-code" class="col-sm-3 control-label">Camp Code</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="4" class="form-control" id="c-code" name="c-code" placeholder="Camp Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="255" class="form-control" id="name" name="name"
                                           placeholder="Official name of the IDP Camp">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-state" class="col-sm-3 control-label">Camp Location - State</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="c-state" name="c-state">
                                        <option>State 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-lga" class="col-sm-3 control-label">Local Govt. Area</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="c-lga" name="c-lga">
                                        <option>LGA 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea rows="3" class="form-control" id="address" name="address"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')

@endsection