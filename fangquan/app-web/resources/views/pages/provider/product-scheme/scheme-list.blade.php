<?php
ufa()->extCss([
        'provider/product-scheme/scheme-list'
]);
ufa()->extJs([
        'provider/product-scheme/scheme-list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-方案列表-->
        <div class="right-box">
            <div class="choose">
                <a href="{{ route('provider.product-scheme.product',['provider_id'=>$provider_id ?? 0]) }}">产品</a>
                <a class="choose-active"
                   href="{{ route('provider.product-scheme.scheme',['provider_id'=>$provider_id ?? 0]) }}">方案</a>
            </div>

            @if(!empty($items))
                <p class="num">共计<span>&nbsp;{{ $pager['total'] ?? 0 }}&nbsp;</span>个方案</p>
                <ul class="scheme-box">
                    @foreach($items ?? [] as $item)
                        <li>
                            <a href="{{ route('provider.product-detail.scheme.detail',['provider_id'=>$provider_id ?? 0,'provider_scheme_id'=>$item['id'] ?? 0]) }}">
                                <img src="{{ $item['thumb_programme_picture'] or '' }}">
                                <p class="title">{{ $item['title'] or '' }}</p>
                                <p class="price">市场参考价：<span>￥{{ $item['price_most']['most_low'] or '' }}
                                        ~ {{ $item['price_most']['most_high'] or '' }}</span></p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                @include('common.no-data', ['title' => '暂无数据'])
            @endif

            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->render() !!}
                </div>
            @endif
        </div>
    </div>

@endsection