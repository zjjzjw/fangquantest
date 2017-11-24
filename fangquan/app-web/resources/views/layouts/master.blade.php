<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="mobile-agent" content="format=html5;url={!!$meta_url or ''!!}">

    <meta id="viewport" name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>{!! $meta_title or '房圈' !!}</title>
    <meta name="Keywords" content="{!!$meta_keyword or ''!!}"/>
    <meta name="Description" content="{!!$meta_description or ''!!}"/>
    <meta name="X-CSRF-TOKEN" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    @include('resources.styles')
</head>
<body>
<div id="app">
    <div class="page">
        @section('master.main')
            <div class="content">
                @yield('master.content')
            </div>
        @show
        @section('master.footer')
            <div class="footer">
                @include('partials.footer')
            </div>
        @show
    </div>
</div>
<?php

ufa()->addParam(
        [
                'login_info' => !empty($basic_data['login_info']) ? $basic_data['login_info'] : new stdClass(),
                'token'      => csrf_token(),
        ]);
?>

@include('resources.scripts')
</body>


</html>
