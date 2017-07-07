@extends('layouts.deo')
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">Verify IDP</h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="IdpUpdateForm" method="post" action="{{route('idp.update')}}">
                    <input type="hidden" name="id" value="{{$IDP->id}}">
                    <fieldset>
                        <legend>{{$IDP->name()}}</legend>
                        <div class="row bg-info">
                            <div class="col-sm-4">
                                <div class="bg-info pic-container">
                                    <img class="img-responsive img-thumbnail" itemprop="image" src="{{$IDP->photoUrl}}" alt="{{$IDP->name()}}"
                                         id="user-image"/>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div id="biomet-container">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <!--Fingerprint Capture-->
    <script src="{{asset('biomet/assets/dtjava.js')}}" type="text/javascript"></script>
    <script>
      var jnlp_content = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxqbmxwIHNwZWM9IjEuMCIgeG1sbnM6amZ4PSJodHRwOi8vamF2YWZ4LmNvbSIgaHJlZj0iQmlvbWV0cnkuam5scCI+DQogIDxpbmZvcm1hdGlvbj4NCiAgICA8dGl0bGU+QmlvbWV0cnk8L3RpdGxlPg0KICAgIDx2ZW5kb3I+Q0hVS1dVREk8L3ZlbmRvcj4NCiAgICA8ZGVzY3JpcHRpb24+bnVsbDwvZGVzY3JpcHRpb24+DQogICAgPG9mZmxpbmUtYWxsb3dlZC8+DQogIDwvaW5mb3JtYXRpb24+DQogIDxyZXNvdXJjZXM+DQogICAgPGoyc2UgdmVyc2lvbj0iMS42KyIgaHJlZj0iaHR0cDovL2phdmEuc3VuLmNvbS9wcm9kdWN0cy9hdXRvZGwvajJzZSIvPg0KICAgIDxqYXIgaHJlZj0iQmlvbWV0cnkuamFyIiBzaXplPSI2MjQzNSIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICAgIDxqYXIgaHJlZj0ibGliXGRwb3RhcGkuamFyIiBzaXplPSI2NzQ5MCIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICAgIDxqYXIgaHJlZj0ibGliXGRwb3RqbmkuamFyIiBzaXplPSIxNDE3OSIgZG93bmxvYWQ9ImVhZ2VyIiAvPg0KICAgIDxqYXIgaHJlZj0ibGliXG15c3FsLWNvbm5lY3Rvci1qYXZhLTUuMS40Mi1iaW4uamFyIiBzaXplPSIxMDM2MDMwIiBkb3dubG9hZD0iZWFnZXIiIC8+DQogIDwvcmVzb3VyY2VzPg0KPHNlY3VyaXR5Pg0KICA8YWxsLXBlcm1pc3Npb25zLz4NCjwvc2VjdXJpdHk+DQogIDxhcHBsZXQtZGVzYyAgd2lkdGg9IjgwMCIgaGVpZ2h0PSI2MDAiIG1haW4tY2xhc3M9ImNvbS5qYXZhZngubWFpbi5Ob0phdmFGWEZhbGxiYWNrIiAgbmFtZT0iQmlvbWV0cnkiID4NCiAgICA8cGFyYW0gbmFtZT0icmVxdWlyZWRGWFZlcnNpb24iIHZhbHVlPSI4LjArIi8+DQogIDwvYXBwbGV0LWRlc2M+DQogIDxqZng6amF2YWZ4LWRlc2MgIHdpZHRoPSI4MDAiIGhlaWdodD0iNjAwIiBtYWluLWNsYXNzPSJiaW9tZXRyeS5NYWluIiAgbmFtZT0iQmlvbWV0cnkiIC8+DQogIDx1cGRhdGUgY2hlY2s9ImFsd2F5cyIvPg0KPC9qbmxwPg0K';
      function launchApplication(jnlpfile) {
        dtjava.launch({
            url: '{{asset('biomet/Biometry.jnlp')}}',
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
            url: '{{asset('biomet/Biometry.jnlp')}}',
            placeholder: 'biomet-container',
            width: '600',
            height: '232',
            jnlp_content: jnlp_content,
            params: <?= json_encode($api_data, JSON_FORCE_OBJECT); ?>
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
