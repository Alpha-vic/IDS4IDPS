@extends('layouts.admin')
@section('content')
    <div class="container">
        <form action="{{route('location.manage_state_list')}}" method="post" id="manageList" onsubmit="return false;">
            <input name="action" value="" type="hidden">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        Locations - States
                        <span class="pull-right">
                        <!-- Split button -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newStateModal">Add State</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                &nbsp;<span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="disabled small">with selected...</a></li>
                                <li role="separator" class="divider"></li>
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
                        <th width="15%">State Code</th>
                        <th>Name</th>
                        <th width="10%">LGAs</th>
                        <th width="10%">Camps</th>
                        <th width="3%"><input type="checkbox" class="toggle-btn" data-toggle="input.togglable"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sn = startSN($states); ?>
                    @foreach($states as $state)
                        <tr @if($state->trashed()) class="warning" @endif >
                            <td>{{$sn++}}</td>
                            <td>{{$state->code}}</td>
                            <td>{{$state->name}}</td>
                            <td><a href="{{route('admin.locations_lgas',['state_code'=>$state->code])}}">{{count($state->lgas)}}</a></td>
                            <td>{{count($state->camps)}}</td>
                            <td><input name="id[]" type="checkbox" value="{{$state->id}}" class="togglable"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-center">{{$states->links()}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newStateModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form onsubmit="return false;" id="newStateForm" action="{{route('location.add_state')}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Add New Location - State</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="s-code" class="col-sm-3 control-label">Code</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="4" class="form-control" id="s-code" name="code" placeholder="e.g AD" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="s-name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="255" class="form-control" id="s-name" name="name" placeholder="e.g Adamawa"
                                           required>
                                </div>
                            </div>
                            <div class="text-center padding-1em"><span id="notify"></span></div>
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
    <script type="text/javascript" src="{{asset('js/app.list-manager.js')}}"></script>
    <script type="text/javascript">
      $(function () {
        var $newStateForm = $('#newStateForm');
        var NP = $('#notify', $newStateForm);
        $newStateForm.submit(function (e) {
          e.preventDefault();
          $('button[type=submit]', $newStateForm).attr('disabled', true);
          ajaxCall({
            url: $newStateForm.prop('action'),
            method: "POST",
            data: $newStateForm.serialize(),
            onSuccess: function (response) {
              notify(NP, response);
              if (response.status == true) {
                window.location.reload();
              }
            },
            onFailure: function (xhr) {
              handleHttpErrors(xhr, $newStateForm, '#notify');
            },
            onComplete: function () {
              $('button[type=submit]', $newStateForm).removeAttr('disabled');
            }
          });
        });
      });
    </script>
@endsection