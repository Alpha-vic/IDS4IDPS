@extends('layouts.deo')
@section('extra_heads')
    @parent
    <link href="{{asset('css/cropper.min.css')}}" rel="stylesheet">
    <style>
        .pic-container {
            position: relative;
            text-align: center !important;
        }

        .pic-container .after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 4px;
        }

        .pic-container:hover .after {
            background: rgba(0, 0, 0, .1);
        }

        img#user-image, img#image-preview {
            max-width: 100%;
        }

        img#user-image {
            border: 2px solid #fff;
            border-radius: 4px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">Enroll New Int. Displaced Person</h2>
            </div>
        </div>
        <div>
            <form class="form-horizontal" id="IdpUpdateForm" method="post" action="{{route('idp.update')}}">
                <input type="hidden" name="id" value="{{$IDP->id}}">
                <div class="form-group">
                    <label for="camp" class="col-sm-2 control-label">Camp</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="camp" name="camp">
                            <option disabled>-</option>
                            @foreach($camps as $camp)
                                <option value="{{$camp->id}}">{{$camp->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <fieldset>
                    <legend>Basic Info.</legend>
                    <div class="form-group">
                        <label for="f-name" class="col-sm-2 control-label">Names</label>
                        <div class="col-sm-3">
                            <input type="text" maxlength="255" class="form-control" id="f-name" name="first-name" value="{{$IDP->first_name}}"
                                   placeholder="First name">
                        </div>
                        <div class="col-sm-3">
                            <label for="m-name" class="sr-only">Middle Name</label>
                            <input type="text" maxlength="255" class="form-control" id="m-name" name="middle-name" value="{{$IDP->middle_name}}"
                                   placeholder="Middle name">
                        </div>
                        <div class="col-sm-4">
                            <label for="l-name" class="sr-only">Last Name</label>
                            <input type="text" maxlength="255" class="form-control" id="l-name" name="last-name" value="{{$IDP->last_name}}"
                                   placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-2 control-label">Sex</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="sex" name="sex">
                                <option disabled>-</option>
                                <option value="F" @if('F'==$IDP->sex) selected @endif>Female</option>
                                <option value="M" @if('M'==$IDP->sex) selected @endif>Male</option>
                            </select>
                        </div>
                        <label for="blood-group" class="col-sm-2 control-label">Blood Group</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="blood-group" name="blood-group">
                                <option disabled>-</option>
                                <option value="A" @if('A'==$IDP->blood_group) selected @endif>A</option>
                                <option value="B" @if('B'==$IDP->blood_group) selected @endif>B</option>
                                <option value="O" @if('O'==$IDP->blood_group) selected @endif>O</option>
                                <option value="AB" @if('AB'==$IDP->blood_group) selected @endif>AB</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birth-date" class="col-sm-2 control-label">Date of Birth</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="birth-date" name="birth-date">
                        </div>
                        <label for="height" class="col-sm-2 control-label">Height (ft.)</label>
                        <div class="col-sm-4">
                            <input type="number" max="12" min="0.5" step="0.01" class="form-control" id="height" name="height"
                                   value="{{$IDP->height}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State of Origin</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="state" name="state">
                                <option disabled selected>-</option>
                                @if(is_object($IDP->state))
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" @if($state->id==$IDP->state->id) selected @endif>{{$state->name}}</option>
                                    @endforeach
                                @else
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label for="lga" class="col-sm-2 control-label">Local Govt.</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="blood-group" name="blood-group">
                                <option disabled selected>-</option>
                                @if(is_object($IDP->lga))
                                    @foreach($lgas as $lga)
                                        <option value="{{$lga->id}}" @if($lga->id==$IDP->lga->id) selected @endif>{{$lga->name}}</option>
                                    @endforeach
                                @else
                                    @foreach($lgas as $lga)
                                        <option value="{{$lga->id}}">{{$lga->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" maxlength="255" class="form-control" id="email" name="email" value="{{$IDP->email}}"
                                   placeholder="name@domain.com">
                        </div>
                        <label for="phone" class="col-sm-2 control-label">Mobile Phone</label>
                        <div class="col-sm-4">
                            <input type="tel" maxlength="255" class="form-control" id="phone" name="phone" value="{{$IDP->phone}}"
                                   placeholder="+234 xxx xxx xxxx">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea rows="4" class="form-control" id="description" name="description">{{$IDP->description}}</textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Biometrics</legend>
                    <div class="row bg-info">
                        <div class="col-sm-3">
                            <div class="bg-info pic-container">
                                <img class="img-responsive img-thumbnail" itemprop="image" src="{{$IDP->photoUrl}}" alt="{{$IDP->name()}}"
                                     id="user-image"/>
                                <div class="after center-align padding-top-4em">
                                    <div>
                                        <label class="btn" for="image-upload">
                                            <span class="glyphicon glyphicon-camera"></span>
                                        </label>
                                        <input class="hide" id="image-upload" type="file"/>
                                    </div>
                                    <p>Change picture</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="text-center">
                                <h4>Fingerprints</h4>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr class="divider">
                <div class="text-right padding-btm-4em">
                    <strong id="notify"></strong>
                    <button type="submit" class="btn btn-primary">Enroll IDP</button>
                    <button type="button" class="btn btn-warning" id="x-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    $image_url = $IDP->photoUrl;
    $image_alt_text = $IDP->name();
    ?>
    @include('parts.image_previewer')
@endsection
@section('extra_scripts')
    <script src="{{asset('js/imageupload/cropper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/imageupload/preview.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        var $this = $('#IdpUpdateForm');
        var NP = $('#notify', $this);
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

        //Cancellation
        $('#x-btn').click(function (e) {
          e.preventDefault();
          $('button', $this).attr('disabled', true);
          ajaxCall({
            url: '<?= route('idp.discard') ?>',
            method: "POST",
            data: $this.serialize(),
            onSuccess: function (response) {
              notify(NP, response);
              if (response.status == true) {
                //ToDO
              }
            },
            onFailure: function (xhr) {
              handleHttpErrors(xhr, $this, '#notify');
            },
            onComplete: function () {
              $('button', $this).removeAttr('disabled');
            }
          });
        })
      });

      //Picture Processing
      var input = $('#image-upload');
      var previewer = $('#image-preview');
      var modalWindow = $('#image-editor');
      var handlerUrl = '<?= route('idp.set_photo') ?>';
      var prefWidth = 400;
      var prefHeight = 600;

      input.change(function () {
        previewImage(this, previewer);
        $('.btn', modalWindow).prop('disabled', false);
        modalWindow.modal('show');
      });
      modalWindow.on('shown.bs.modal', function () {
        previewer.cropper({
          aspectRatio: 1,
          viewMode: 2,
          setDragMode: 'move',
          minCropBoxWidth: $(window).width() >= 1024 ? 100 : prefWidth,
          autoCropArea: 0.1
        });
      });
      initButtons(previewer, prefWidth, prefHeight, handlerUrl, modalWindow, input, function (formData) {
        formData.append('id', $('input[name=id]').val())
      });
    </script>
@endsection
