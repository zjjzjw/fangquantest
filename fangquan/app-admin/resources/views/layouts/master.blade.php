<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="mobile-agent" content="format=html5;url={!!$meta_url or ''!!}">

    <meta id="viewport" name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>{!! $meta_title or '管理系统' !!}</title>
    <meta name="Keywords" content="{!!$meta_keyword or ''!!}"/>
    <meta name="Description" content="{!!$meta_description or ''!!}"/>
    <meta name="X-CSRF-TOKEN" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    @include('resources.styles')
</head>
<body>
<div id="app">
    @section('master.header')
        <div class="header">
            @include('partials.header')
        </div>
    @show

    @section('master.main')
        <div class="content">
            <div class="sidenav">
                @include('partials.sidenav')
            </div>

            <div class="main-content">
                <div class="shell-content">
                    @yield('master.content')
                </div>
            </div>
        </div>
    @show
    @section('master.footer')
        <div class="footer">
            @include('partials.footer')
        </div>
    @endsection
</div>
@include('resources.scripts')


</body>


</html>
