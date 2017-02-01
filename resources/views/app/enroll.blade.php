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
            color: #00F;
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
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="camp" class="col-sm-2 control-label">Camp</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="camp" name="camp">
                            <option>--</option>
                        </select>
                    </div>
                </div>
                <fieldset>
                    <legend>Basic Info.</legend>
                    <div class="form-group">
                        <label for="f-name" class="col-sm-2 control-label">Names</label>
                        <div class="col-sm-3">
                            <input type="text" maxlength="255" class="form-control" id="f-name" name="first-name" placeholder="First Name">
                        </div>
                        <div class="col-sm-3">
                            <label for="m-name" class="sr-only">Middle Name</label>
                            <input type="text" maxlength="255" class="form-control" id="m-name" name="middle-name" placeholder="Middle Name">
                        </div>
                        <div class="col-sm-4">
                            <label for="l-name" class="sr-only">Last Name</label>
                            <input type="text" maxlength="255" class="form-control" id="l-name" name="last-name" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-2 control-label">Sex</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="sex" name="sex">
                                <option>-</option>
                                <option value="F">Female</option>
                                <option value="M">Male</option>
                            </select>
                        </div>
                        <label for="blood-group" class="col-sm-2 control-label">Blood Group</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="blood-group" name="blood-group">
                                <option>-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="O">O</option>
                                <option value="AB">AB</option>
                            </select>
                        </div>
                        <label for="height" class="col-sm-2 control-label">Height (ft.)</label>
                        <div class="col-sm-2">
                            <input type="number" max="12" min="0.5" step="0.01" class="form-control" id="height" name="height">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State of Origin</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="state" name="state">
                                <option>-</option>
                            </select>
                        </div>
                        <label for="lga" class="col-sm-2 control-label">Local Govt.</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="blood-group" name="blood-group">
                                <option>-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" maxlength="255" class="form-control" id="email" name="email" placeholder="name@domain.com">
                        </div>
                        <label for="phone" class="col-sm-2 control-label">Mobile Phone</label>
                        <div class="col-sm-4">
                            <input type="tel" maxlength="255" class="form-control" id="phone" name="phone" placeholder="+234 xxx xxx xxxx">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea rows="4" class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Biometrics</legend>
                    <div class="row bg-info">
                        <div class="col-sm-3">
                            <div class="bg-info pic-container">
                                <img class="img-responsive img-thumbnail" itemprop="image" src="{{asset('images/defaults/user.png')}}" alt="#"
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
                    <button type="submit" class="btn btn-primary">Enroll IDP</button>
                    <button type="reset" class="btn btn-default">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    $image_url = asset('images/defaults/user.png');
    $image_alt_text = 'New IDP';
    ?>
    @include('parts.image_previewer')
@endsection
@section('extra_scripts')
    <script src="{{asset('js/imageupload/cropper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/imageupload/preview.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        //Profile Picture Processing
        var input = $('#image-upload');
        var previewer = $('#image-preview');
        var modalWindow = $('#image-editor');
        var handlerUrl = '<?= url()->route('account.profile.image') ?>';
        var prefWidth = 300;
        var prefHeight = 300;

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

        initButtons(previewer, prefWidth, prefHeight, handlerUrl, modalWindow, input);
      });
    </script>
@endsection
