@extends('layouts.account')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="credentialsForm" role="form" method="POST" action="{{ route('user.change_password') }}"
                              onsubmit="return false;">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label for="current_password" class="col-md-3 control-label">Current Password</label>

                                    <div class="col-md-8">
                                        <input id="current_password" type="password" class="form-control" name="current_password" required
                                               autocomplete="off">

                                        @if ($errors->has('current_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="new-password" class="col-md-3 control-label">New Password</label>

                                    <div class="col-md-8">
                                        <input id="new-password" type="password" class="form-control" name="password" required autocomplete="off">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-3 control-label">Confirm New Password</label>

                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                               autocomplete="off">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <div class="col-xs-12 col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        Update Credentials
                                    </button>
                                </div>
                            </div>
                            <div class="text-center padding-1em"><span id="notify"></span></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script type="text/javascript">
      $(function () {
        var $this = $('#credentialsForm');
        var NP = $('#notify');
        $this.submit(function (e) {
          e.preventDefault();
          $('button[type=submit]', $this).attr('disabled', true);
          ajaxCall({
            url: $this.attr('action'),
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