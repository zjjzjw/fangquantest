<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/provider/index')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/provider/index')); ?>

<?php
App\Wap\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? [],
));
?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="provider-box">
        <ul class="common-list">
            @if(!empty($items))
            @foreach(($items ?? []) as $key =>$item)
                <li class="logo-box">
                    <a href="{{route('exhibition.provider.detail', ['provider_id' => $item['id']])}}">
                        <div class="img-box">
                            <img src="{{$item['logo_url'] or ""}}" alt="">
                            <p>{{$item['brand_name'] or ""}}</p>
                        </div>
                        <div class="list-detail">
                            <p>{{$item['company_name'] or ""}}</p>
                            <ul>
                                @foreach(($item['provider_main_categories'] ?? []) as $key =>$category)
                                    <li style="background-color:{{$category['color'] or ""}}">{{$category['name'] or ""}}</li>
                                @endforeach
                            </ul>
                            @if(!empty($item['company_type_name']))
                                <p class="company-type">公司类型：<span>{{$item['company_type_name'] or ""}}</span></p>
                            @endif
                        </div>
                        <div class="clear"></div>
                        @if(!empty($item['city_name'] ))
                            <p class="address">
                                <img src="/www/image/exhibition/exhibition-h5/address.png" alt="">
                                {{$item['city_name'] or "  "}}
                            </p>
                        @endif
                        <div class="clear"></div>
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
    </div>

    <script type="text/html" id="common_list_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
        <li class="logo-box">
            <a href="<%='/exhibition/provider/detail/' + names[i].id %>">
                <div class="img-box">
                    <img src="<%=names[i].logo_url%>" alt="">
                    <p><%=names[i].brand_name%></p>
                </div>
                <div class="list-detail">
                    <p><%=names[i].company_name%></p>
                    <ul>
                        <% for (var j =0; j < names[i].provider_main_categories.length; j++ ) { %>
                           <li style="background-color:<%=names[i].provider_main_categories[j].color%>"> <%=names[i].provider_main_categories[j].name%> </li>
                        <% } %>
                    </ul>
                    <% if(names[i].company_type_name) { %>
                        <p class="company-type">公司类型：<span><%=names[i].company_type_name%></span></p>
                    <% } %>
                </div>
                <div class="clear"></div>
                <% if(names[i].city_name) {  %>
                <p class="address"><img src="/www/image/exhibition/exhibition-h5/address.png"
                                        alt=""><%=names[i].city_name%></p>
                <% } %>
                <div class="clear"></div>
            </a>
        </li>
        <% } %>
    </script>
@endsection


