@extends('layouts.admin')
@section('content')
    <div class="container">
        <form action="{{route('camp.manage_list')}}" method="post" id="manageList" onsubmit="return false;">
            <input name="action" value="" type="hidden">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        IDP Camps
                        <span class="pull-right">
                        <!-- Split button -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newCampModal">New Camp</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                &nbsp;<span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                        <ul class="dropdown-menu">
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
                        <th width="10%">Code</th>
                        <th>Name</th>
                        <th width="25%">Address</th>
                        <th width="3%"><input type="checkbox" class="toggle-btn" data-toggle="input.togglable"></th>
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
                            <td><input name="id[]" type="checkbox" value="{{$camp->id}}" class="togglable"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-center">{{$camps->links()}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
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
                                    <input type="text" maxlength="4" class="form-control" id="c-code" name="code" placeholder="Camp Code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="255" class="form-control" id="name" name="name"
                                           placeholder="Official name of the IDP Camp" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-lga" class="col-sm-3 control-label">Local Govt. Area</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="c-lga" name="lga" required>
                                        @foreach($lgas as $lga)
                                            <option value="{{$lga->id}}">{{$lga->state->name}} - {{$lga->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea rows="3" class="form-control" id="address" name="address" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center padding-1em"><span id="notify"></span></div>
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
    <script type="text/javascript" src="{{asset('js/app.list-manager.js')}}"></script>
    <script type="text/javascript">
      $(function () {
        var $newCampForm = $('#newCampForm');
        var NP = $('#notify', $newCampForm);
        $newCampForm.submit(function (e) {
          e.preventDefault();
          $('button[type=submit]', $newCampForm).attr('disabled', true);
          ajaxCall({
            url: $newCampForm.prop('action'),
            method: "POST",
            data: $newCampForm.serialize(),
            onSuccess: function (response) {
              notify(NP, response);
              if (response.status == true) {
                window.location.reload();
              }
            },
            onFailure: function (xhr) {
              handleHttpErrors(xhr, $newCampForm, '#notify');
            },
            onComplete: function () {
              $('button[type=submit]', $newCampForm).removeAttr('disabled');
            }
          });
        });
      });
    </script>
@endsection