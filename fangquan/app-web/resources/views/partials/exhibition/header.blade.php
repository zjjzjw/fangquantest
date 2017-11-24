<?php
$url_name = request()->route()->getName();
$class_provider = ($url_name == 'exhibition.new-provider-list') ? 'to-developer' : 'to-provider';
$class_developer = ($url_name == 'exhibition.developer-list') ? 'to-developer' : 'to-provider';
?>

<div class="exhibition">
    <div class="exhibition-header">
        <div class="logo">
            <a href="/"><img src="/www/images/home/exhibition-logo2.png" alt=""></a>
            <div class="title">
                <p class="name">2017首届房地产全产业链B2B创新采购展</p>
                <p class="translate-name">The First B2B Innovation Procurement Exhibition Of Real Estate Whole Industrial Chain</p>
                <p class="time">中国·上海 国家会展中心|2017.12.06</p>
            </div>
        </div>
        <div class="tab-box">
            <a class="@if($url_name == 'home.index') active @endif" href="{{route('home.index')}}">首页</a>
            <a class="@if($url_name == 'information.list') active @elseif($url_name == 'information.detail') active @endif" href="{{route('information.list')}}">新闻资讯</a>
            <a class="@if($url_name == 'review.list') active @elseif($url_name == 'review.detail') active @endif" href="{{route('review.list')}}">展会回顾</a>
            <a class="exhibitor-list @if($url_name == 'exhibition.developer-list') active @elseif($url_name == 'exhibition.new-provider-list') active @endif" href="javascript:void(0);">展商列表</a>
            <div class="list-box" style="display: none;">
                <i class="iconfont">&#xe614;</i>
                <div class="list-item">
                    <a class="{{$class_developer or ''}}" href="{{route('exhibition.developer-list')}}">开发商</a>
                    <a class="{{$class_provider or ''}}" href="{{route('exhibition.new-provider-list')}}">供应商</a>
                </div>
            </div>

            <div id="search-box" class="search-box">
                <div class="search">
                    <form class="search-input" onsubmit="return false;">
                        <div class="content-wrap">
                            <i class="iconfont search-btn">&#xe600;</i>
                            <a class="link-type" href="javascript:void(0);"><span>开发商</span><i></i></a>
                            <div class="choose-type" style="display: none;">
                                <a href="javascript:void(0);"><span>开发商</span><i></i></a>
                                <a href="javascript:void(0);"><span>供应商</span></a>
                            </div>
                            <input type="text" name="keyword" placeholder='' id="keyword" class="keyword" value="{{$appends['keyword'] or ''}}">
                            <span class="btn">搜索</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>