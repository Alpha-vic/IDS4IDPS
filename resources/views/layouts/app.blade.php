<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ url('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ url('favicon.png') }}">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
      window.Laravel = <?= json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="{{asset('js/app.js')}}"></script>
    <!--Extra-->
    @yield('extra_heads')
</head>
<body>
@yield('body')

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

@yield('extra_scripts')
</body>
</html>
