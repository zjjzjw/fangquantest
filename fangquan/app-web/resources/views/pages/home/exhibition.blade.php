<?php
ufa()->extCss([
        'home/exhibition'
]);
ufa()->extJs([
        'home/exhibition'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="bg-box">
        <div class="swiper-container swiper-container1" id="top-pic">
            <ul class="swiper-wrapper">
                @foreach(($banners['items'] ?? []) as $banner)
                    @foreach(($banner['thumbnail_images'] ?? []) as $image)
                        <li class="swiper-slide">
                            <a href="{{$banner['url'] or ''}}">
                                @if($browser == "IE" && floatval($version) < 10)
                                    <img src="{{$image['url'] or ''}}">
                                @else
                                    <div style="background-image:url({{$image['url']}});background-repeat: no-repeat;background-position:center center;
                                            width:100%;height:100%;background-size: cover;">
                                    </div>
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>




    <div class="main-info"> 

        <div class="broadcast-box">

            <img src="/www/images/exhibition/0004.jpg">
            <a href="{{route('exhibition.broadcast.detail')}}">现场直播>>></a>
        </div>

        <div class="info-box">
            <ul>
                <li>
                    <div class="info-item">
                        <a href="{{route('exhibition.introduce')}}">
                            <img src="/www/images/home/zhanhui-bg.jpeg">
                            <p class="pic-info">展会概况</p>
                        </a>
                    </div>
                </li>

                <li>
                    <div class="info-item detail-info service-info">
                        <a href="{{route('exhibition.service')}}"><p class="title">展会服务</p></a>
                        <a href="{{route('exhibition.service')}}#daily-planning"><p>参展日程规划</p></a>
                        <a href="{{route('exhibition.service')}}#exhibition-layout"><p>展会布局</p></a>
                        <a href="{{route('exhibition.service')}}#exhibition-notice"><p>参展须知</p></a>
                        <a href="{{route('exhibition.service')}}#exhibition-tour"><p>餐饮交通导览</p></a>
                    </div>

                </li>
                <li>
                    <div class="info-item">
                        <a href="{{route('exhibition.result')}}">
                            <img src="/www/images/home/zhanhui-bg.jpeg">
                            <p class="pic-info">展会成果</p>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="info-item detail-info contact-info">
                        <p class="title">联系方式</p>
                        <p class="company-name">中国建材市场协会工程招标采购分会</p>
                        <p class="address">地址：北京市丰台区杜家坎南路9号亿旺家居B座四层</p>
                        <p>电话：137 8899 2178</p>
                        <p>邮箱：<span>bmp1206@caigouxiehui.com</span></p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="developer img-box">
            <div class="title special-title">
                <p>开发商<a href="{{route('exhibition.developer-list')}}">更多开发商></a><a
                            href="{{route('exhibition.developer-project-list')}}">更多地产项目></a></p>
            </div>
            <div class="developer-box">
                <ul>
                    @foreach($developers as $developer)
                        <li class="brand-item">
                            <a target="_blank"
                               href="{{route('exhibition.developer-project-list',['developer_id' => $developer['id']])}}">
                                <img src="{{$developer['logo_url'] or ''}}" alt="">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="provider img-box">
            <div class="title">
                <p>供应商<a href="{{route('exhibition.new-provider-list')}}">更多></a></p>
            </div>
            <div class="provider-box">
                <ul>
                    @foreach($providers as $provider)
                        <li class="brand-item">
                            <a target="_blank"
                               href="{{route('exhibition.provider.detail', ['id' => $provider['id']])}}">
                                <img src="{{$provider['logo_url'] or ''}}" alt="">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="line"></div>
        </div>
    </div>
    @include('partials.exhibition.cooperation-unit')
    @include('partials.exhibition.friendly-link')
@endsection
