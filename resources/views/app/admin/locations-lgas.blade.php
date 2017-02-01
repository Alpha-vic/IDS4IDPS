@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Locations - LGAs in {{$state->name}}
                    <span class="pull-right">
                        <a class="btn btn-sm btn-default" href="{{route('admin.locations_states')}}">
                            <span class="glyphicon glyphicon-step-backward"></span> Back
                        </a>
                        <!-- Split button -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newLgaModal">New LGA</button>
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
                <?php $sn = 1; ?>
                @foreach($lgas as $lga)
                    <tr @if($lga->trashed()) class="warning" @endif >
                        <td>{{$sn++}}</td>
                        <td>{{$lga->code}}</td>
                        <td>{{$lga->name}}</td>
                        <td>---</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newLgaModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form onsubmit="return false;" id="newLgaForm" action="{{route('location.add_lga')}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Add New Location - LGA</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="255" class="form-control" id="name" name="name" placeholder="LGA Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-sm-3 control-label">Code</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="4" class="form-control" id="code" name="code" placeholder="LGA Code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state" class="col-sm-3 control-label">State</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="state" name="state" required>
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    </select>
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
    <script type="text/javascript">
      $(function () {
        var $this = $('#newLgaForm');
        var NP = $('#notify');
        $this.submit(function (e) {
          e.preventDefault();
          $('button[type=submit]', $this).attr('disabled', true);
          ajaxCall({
            url: $this.prop('action'),
            method: "POST",
            data: $this.serialize(),
            onSuccess: function (response) {
              notify(NP, response);
              if (response.status == true) {
                window.location.reload();
              }
            },
            onFailure: function (xhr) {
              handleHttpErrors(xhr, $this, '#notify');
            },
            onComplete: function () {
              $('button[type=submit]', $this).removeAttr('disabled');
            }
          });
        });
      });
    </script>
@endsection