@extends('layouts.deo')
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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-center bg-info sh-20vh">
                                <h4>Photo</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-center bg-info sh-20vh">
                                <h4>Fingerprints</h4>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr class="divider">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Enroll IDP</button>
                    <button type="reset" class="btn btn-default">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection