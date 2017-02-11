@extends('layouts.account')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Profile</div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="profileUpdateForm" role="form" method="POST" action="{{ route('user.update') }}"
                              onsubmit="return false;">
                            {{ csrf_field() }}

                            <fieldset>
                                <legend class="small">Contact Info.</legend>
                                <div class="form-group{{ $errors->has('first_name') || $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="f-name" class="col-md-3 control-label">Name</label>

                                    <div class="col-md-4">
                                        <input id="f-name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required
                                               autofocus placeholder="First name">
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <input id="l-name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required
                                               autofocus placeholder="Last name">
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-3 control-label">E-Mail Address</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" maxlength="100" class="form-control" name="email" value="{{ $user->email }}"
                                               required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="phone" class="col-md-3 control-label">Mobile Number</label>

                                    <div class="col-md-8">
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{ $user->phone }}" required>

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="small">Bank Account Info.</legend>
                                <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                                    <label for="account_name" class="col-md-3 control-label">Account Name</label>

                                    <div class="col-md-8">
                                        <input id="account_name" type="text" class="form-control" name="account_name"
                                               value="{{ $user->account_name }}" required>
                                        @if ($errors->has('account_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('account_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                    <label for="account_number" class="col-md-3 control-label">Account Number</label>

                                    <div class="col-md-8">
                                        <input id="account_number" type="number" min="0" class="form-control" name="account_number"
                                               value="{{ $user->account_number }}" required>
                                        @if ($errors->has('account_number'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                                    <label for="bank_name" class="col-md-3 control-label">Bank Name</label>

                                    <div class="col-md-8">
                                        <input id="bank_name" type="text" class="form-control" name="bank_name"
                                               value="{{ $user->bank_name }}" required>
                                        @if ($errors->has('bank_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="small">Authorization</legend>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-3 control-label">Password</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="off">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <div class="col-xs-12 col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        Update Profile
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
        var $this = $('#profileUpdateForm');
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