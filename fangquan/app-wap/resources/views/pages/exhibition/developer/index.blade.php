<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/developer/index')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/developer/index')); ?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="developer-box">
        <div class="img-box">
            <img src="http://img.fq960.com/FmpB1fLKXmvJnVVNPViOg_oZkF0g" alt="">
        </div>
        <div class="list-box">
            <ul class="activity">
                @foreach(($items ?? []) as $key =>$item)
                    <li>
                        <a href="{{route('exhibition.developer-project.list', ['developer_id' => $item['id']])}}">
                            <img src="{{$item['logo_url']}}" alt="">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="JavaScript:void(0);" class="more-developer">更多</a>
    </div>
    @include('partials.exhibition-h5.developer.developer-footer')

    <script type="text/html" id="developer_tpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
        <li>
            <a href="/exhibition/developer-project/list/?developer_id=<%=data.items[k].id%>"><img src="<%=data.items[k].logo_url%>" alt=""></a>
         </li>
        <% } %>
    </script>

@endsection


