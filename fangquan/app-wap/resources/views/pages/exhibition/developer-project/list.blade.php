<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/developer-project/list')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/developer-project/list')); ?>

<?php
App\Wap\Http\Controllers\Resource::addParam(array(
    'pageInfo' => $appends ?? [],
));
?>

@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="list-box">

        <div class="list-content">
            <ul class="common-list">
                @if(!empty($items))
                    @foreach(($items ?? []) as $key =>$item)
                        <li>
                            <a href="{{route('exhibition.developer-project.detail', ['id' => $item['id']])}}">
                                <p class="title" title="{{$item['name'] or ''}}">{{$item['name'] or ''}}</p>
                                <img src="{{$item['logo_url'] or ''}}" alt="">
                                <div class="list-detail">
                                    <p title="{{$item['developer_name'] or ""}}">{{$item['developer_name'] or ""}}</p>
                                    <p>建筑面积：{{$item['floor_space'] or ""}}m²</p>
                                    <p>项目类型：{{$item['project_category_name'] or ""}}</p>
                                </div>
                                <p class="time"><span>{{$item['time'] or ""}}</span><span><img
                                                src="/www/image/exhibition/exhibition-h5/adress.png"
                                                alt="">{{$item['city_name'] or ""}}</span></p>
                            </a>
                        </li>
                    @endforeach
                @else
                    <div class="content-empty">
                        <img src="/www/image/exhibition/exhibition-h5/content-empty.png" alt="">
                        <p>暂无数据</p>
                    </div>
                @endif
            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <!--下拉分页模板-->
    <script type="text/html" id="common_list_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
        <li>
            <a href="<%='/exhibition/developer-project/detail/' + names[i].id%>">
                <p class="title" title="<%=names[i].name%>"><%=names[i].name%></p>
                <img src="<%=names[i].logo_url%>" alt="">
                <div class="list-detail">
                    <p title="<%=names[i].developer_name%>"><%=names[i].developer_name%></p>
                    <p>建筑面积：<%=names[i].floor_space%>m²</p>
                    <p>项目类型：<%=names[i].project_category_name%></p>
                </div>
                <p class="time"><span><%=names[i].time%></span><span><img
                                src="/www/image/exhibition/exhibition-h5/adress.png"
                                alt=""><%=names[i].city_name%></span></p>
            </a>
        </li>
        <% } %>
    </script>
@endsection


