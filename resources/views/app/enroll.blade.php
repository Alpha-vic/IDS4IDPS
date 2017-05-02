@extends('layouts.deo')
@section('extra_heads')
    @parent
    <link href="{{asset('css/cropper.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.image-preview.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">Enroll New Int. Displaced Person</h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="IdpUpdateForm" method="post" action="{{route('idp.update')}}">
                    <input type="hidden" name="id" value="{{$IDP->id}}">
                    <div class="form-group">
                        <label for="camp" class="col-sm-2 control-label">Camp</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="camp" name="camp_id" required>
                                <option></option>
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
                                <input type="text" maxlength="255" class="form-control" id="f-name" name="first_name" value="{{$IDP->first_name}}"
                                       placeholder="First name" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="m-name" class="sr-only">Middle Name</label>
                                <input type="text" maxlength="255" class="form-control" id="m-name" name="middle_name" value="{{$IDP->middle_name}}"
                                       placeholder="Middle name">
                            </div>
                            <div class="col-sm-4">
                                <label for="l-name" class="sr-only">Last Name</label>
                                <input type="text" maxlength="255" class="form-control" id="l-name" name="last_name" value="{{$IDP->last_name}}"
                                       placeholder="Last name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sex" class="col-sm-2 control-label">Sex</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="sex" name="sex" required>
                                    <option></option>
                                    <option value="F" @if('F'==$IDP->sex) selected @endif>Female</option>
                                    <option value="M" @if('M'==$IDP->sex) selected @endif>Male</option>
                                </select>
                            </div>
                            <label for="blood-group" class="col-sm-2 control-label">Blood Group</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="blood-group" name="blood_group" required>
                                    <option></option>
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
                                <input type="date" class="form-control" id="birth-date" name="birth_date" required>
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
                                <select class="form-control" id="state" name="state_id" required>
                                    <option></option>
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
                                <select class="form-control" id="lga" name="lga_id" required>
                                    <option></option>
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
                            <div class="col-sm-9 text-center">
                                <div id="biomet-container">
                                </div>
                                <a href='Biometry.jnlp' onclick="return launchApplication('Biometry.jnlp');">Launch WebStart</a>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="divider">
                    <div class="text-center padding-btm-2em">
                        <button type="submit" class="btn btn-primary">Enroll IDP</button>
                        @if($IDP->status == \App\Models\Person::STATUS_TMP)
                            <button type="button" class="btn btn-warning" id="x-btn">Cancel</button>
                        @endif
                        <div><strong id="notify"></strong></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    $image_url = $IDP->photoUrl;
    $image_alt_text = $IDP->name();
    ?>
    @include('parts.image_previewer')
@endsection
@section('extra_scripts')
    <!--Image Processing-->
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
                setTimeout(function () {
                  window.location = '<?= route('deo.persons'); ?>';
                }, 2000);
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
                window.location = '<?= route('deo.persons'); ?>';
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
      var prefHeight = 400;

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

    <!--Fingerprint Capture-->
    <script src="{{asset('biomet/assets/dtjava.js')}}" type="text/javascript"></script>
    <script>
      var jnlp_content = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxqbmxwIHNwZWM9IjEuMCIgeG1sbnM6amZ4PSJodHRwOi8vamF2YWZ4LmNvbSIgaHJlZj0iQmlvbWV0cnkuam5scCI+DQogIDxpbmZvcm1hdGlvbj4NCiAgICA8dGl0bGU+QmlvbWV0cnk8L3RpdGxlPg0KICAgIDx2ZW5kb3I+Q0hVS1dVREk8L3ZlbmRvcj4NCiAgICA8ZGVzY3JpcHRpb24+bnVsbDwvZGVzY3JpcHRpb24+DQogICAgPG9mZmxpbmUtYWxsb3dlZC8+DQogIDwvaW5mb3JtYXRpb24+DQogIDxyZXNvdXJjZXM+DQogICAgPGoyc2UgdmVyc2lvbj0iMS42KyIgaHJlZj0iaHR0cDovL2phdmEuc3VuLmNvbS9wcm9kdWN0cy9hdXRvZGwvajJzZSIvPg0KICAgIDxqYXIgaHJlZj0iQmlvbWV0cnkuamFyIiBzaXplPSI1OTU4NyIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICAgIDxqYXIgaHJlZj0ibGliXGRwb3RhcGkuamFyIiBzaXplPSI2NzQ5NSIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICAgIDxqYXIgaHJlZj0ibGliXGRwb3RqbmkuamFyIiBzaXplPSIxNDE4MCIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICA8L3Jlc291cmNlcz4NCjxzZWN1cml0eT4NCiAgPGFsbC1wZXJtaXNzaW9ucy8+DQo8L3NlY3VyaXR5Pg0KICA8YXBwbGV0LWRlc2MgIHdpZHRoPSI4MDAiIGhlaWdodD0iNjAwIiBtYWluLWNsYXNzPSJjb20uamF2YWZ4Lm1haW4uTm9KYXZhRlhGYWxsYmFjayIgIG5hbWU9IkJpb21ldHJ5IiA+DQogICAgPHBhcmFtIG5hbWU9InJlcXVpcmVkRlhWZXJzaW9uIiB2YWx1ZT0iOC4wKyIvPg0KICA8L2FwcGxldC1kZXNjPg0KICA8amZ4OmphdmFmeC1kZXNjICB3aWR0aD0iODAwIiBoZWlnaHQ9IjYwMCIgbWFpbi1jbGFzcz0iYmlvbWV0cnkuTWFpbiIgIG5hbWU9IkJpb21ldHJ5IiAvPg0KICA8dXBkYXRlIGNoZWNrPSJhbHdheXMiLz4NCjwvam5scD4NCg==';
      function launchApplication(jnlpfile) {
        dtjava.launch({
            url: 'Biometry.jnlp',
            jnlp_content: jnlp_content
          },
          {
            javafx: '8.0+'
          },
          {}
        );
        return false;
      }

      function javafxEmbedBiometry() {
        dtjava.embed(
          {
            id: 'biometry',
            url: 'Biometry.jnlp',
            placeholder: 'biomet-container',
            width: '600',
            height: '232',
            jnlp_content: jnlp_content,
            params: {
              mode: "Verification",
              choice: "Right",
              url: "127.0.0.1/biomet/enroll_fp.php",
              userID: "",
              template: ""

            }
          },
          {
            javafx: '8.0+'
          },
          {}
        );
      }
      <!-- Embed FX application into web page once page is loaded -->
      dtjava.addOnloadCallback(javafxEmbedBiometry, false);
    </script>
@endsection
