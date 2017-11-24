<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="mobile-agent" content="format=html5;url={!!$meta_url or ''!!}">
    <meta id="viewport" name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>{!! $meta_title or ' 绘房 &middot; 橙诺 ' !!}</title>
    <meta name="Keywords" content="{!!$meta_keyword or ''!!}"/>
    <meta name="Description" content="{!!$meta_description or ''!!}"/>
    <link rel="shortcut icon" href="/favicon.ico"/>

</head>
<body>
<div class="page-wrapper">
    {{--@section('master.header')--}}
    {{--@include('partials.topbar', ['cities' => $city_config ?? [], 'current_city_id' => $current_city_id ?? 0, 'user_name' => $user_name ?? ''])--}}
    {{--@show--}}


    <div class="row collapse page-content">
        <div class="page-main">
            @section('master.main')
                <div class="shell-content">
                    @yield('master.content')
                </div>
            @show
        </div>
    </div>
</div>

{{--@include('resources.scripts')--}}
<script src="/js/app.js" type="application/javascript"></script>
<script src="/js/home/index.js" type="application/javascript"></script>

</body>
</html>
