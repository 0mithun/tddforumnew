<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.1/trix.css">

    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>

    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; align-items: center; }
        .level-item { margin-right: 1em; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .ml-a { margin-left: auto; }
        [v-cloak] { display: none; }
        .ais-highlight > em { background: yellow; font-style: normal; }
        #footer{
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #484848;
            color: #ffffff;
            height: 50px;
            padding: 15px;
        }
        
        .footer-content{

        }
        .footer-menu{
            margin: 0px;
            padding: 0px;
            list-style:none;
        }
        .footer-menu li{
            float: left;
            display: inline-block;
        }
        .footer-menu li a{
            display: block;
            padding: 0px 10px;
            color: #ffffff;
        }

        .navbar {
            margin-bottom: 5px;
        }
    </style>

    @yield('head')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include ('layouts.nav')

    @yield('content')
    @include('layouts.footer')
    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@php
    $tinyapikey = config('services.tiny.key');
    $url = "https://cdn.tiny.cloud/1/".$tinyapikey."/tinymce/5/tinymce.min.js";
@endphp
<script src="{{ $url  }}" referrerpolicy="origin"></script>



@yield('scripts')

@yield('footer_script')

</body>
</html>
