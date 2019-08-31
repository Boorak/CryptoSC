<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{asset('css/vendor/bulma.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/custom.css')}}">

    <!-- Font Awsome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"
            integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ"
            crossorigin="anonymous"></script>
    <!--/Font Asome-->

    <!-- Chart Core -->
    <script type="text/javascript" src="{{asset('chart/charting_library/charting_library.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('chart/datafeeds/udf/dist/polyfills.js')}}"></script>
    <script type="text/javascript" src="{{asset('chart/datafeeds/udf/dist/bundle.js')}}"></script>
    <!-- End Chart Core -->

    <script>
        window.App = {!!
         json_encode([
                'signedIn' => \Illuminate\Support\Facades\Auth::check(),
                'user' => \Illuminate\Support\Facades\Auth::user(),
         ])
         !!};
    </script>

</head>
<body>

<div id="app">
    <analysis-chart></analysis-chart>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- /Scripts -->
</body>
</html>