<?php
ufa()->extCss([
        'exhibition/developer-list'
]);
ufa()->extJs([
        'exhibition/developer-list'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="developer-list-box">
        @if(!empty($items))
            <ul class="developer-item">
                @foreach(($items ?? []) as $item)
                    <li>
                        <a href="{{route('exhibition.provider.detail', ['id' => $item['id']])}}">
                            <div class="info-img">
                                <img src="{{$item['logo_url'] or ''}}">
                                <p>{{$item['brand_name'] or ''}}</p>
                            </div>
                            <div class="info-detail">
                                <p class="title">{{$item['company_name'] or ''}}</p>
                                <p class="main-products">主营产品：{{$item['provider_main_category'] or ''}}</p>
                                <p class="register-money">注册资金：<span>{{$item['registered_capital'] or 0}}万</span></p>
                                <p class="address">所在地：{{$item['province_name'] or ''}} {{$item['city_name'] or ''}}
                                    <span class="product-num">共{{$item['product_count'] or 0}}种产品</span><span
                                            class="case-num">案例{{$item['programme_count'] or 0}}</span></p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            {{--分页--}}
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->appends($appends)->render() !!}
                </div>
            @endif
        @else
            @include('common.no-data',['title'=>'暂无内容'])
        @endif
    </div>
    @include('partials.exhibition.friendly-link')
@endsection