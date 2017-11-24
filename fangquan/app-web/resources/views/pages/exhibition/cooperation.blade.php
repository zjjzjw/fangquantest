<?php
ufa()->extCss([
    'exhibition/cooperation'
]);
ufa()->extJs([
    'exhibition/cooperation'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.nav')
        <div class="exhibition-content">
            <div class="mechanism-box">
                <div class="mechanism-title">
                    <p>合作机构</p>
                </div>
                <div class="mechanism-list-box">
                    <div class="top-left">
                        <div class="left-img">
                            <img src="/www/images/exhibition/WechatIMG130.jpeg" alt="">
                        </div>
                        <p>主办单位：中国建材市场协会工程招标采购分会</p>
                    </div>
                    <div class="top-right special-style">
                        <div class="right-img">
                            <img src="/www/images/exhibition/WechatIMG132.jpeg" alt="" alt="">
                        </div>
                        <p>协办单位：上海绘房信息科技有限公司</p>
                    </div>
                    <div class="bottom-right">
                        <div class="bottom-right-img">
                            <img src="/www/images/exhibition/WechatIMG131.jpeg" alt="" alt="">
                        </div>
                        <p>承办单位：上海檐宇信息咨询有限公司</p>
                    </div>
                    <div class="bottom-left  special-style">
                        <div class="bottom-img">
                            <img src="/www/images/exhibition/WechatIMG133.jpeg" alt="">
                        </div>
                        <p>全程战略合作：方太集团</p>
                    </div>
                </div>
            </div>
            <div class="media-box">
                <div class="media-title">
                    @foreach(($media_list ?? []) as $item)
                        <div class="img-box">
                            <p>{{$item['type_name']}}</p>
                            <div class="style-line">
                                @foreach(($item['list'] ?? []) as $value)
                                    <div class="media-img">
                                        <img src="{{$value['image_url'] or ''}}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection