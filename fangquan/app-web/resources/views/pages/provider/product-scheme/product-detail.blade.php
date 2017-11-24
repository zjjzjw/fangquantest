<?php
ufa()->extCss([
        'provider/product-scheme/product-detail'
]);
ufa()->extJs([
        'provider/product-scheme/product-detail',
]);
ufa()->addParam(
        [
                'provider_id'         => $provider_id ?? 0,
                'provider_product_id' => $id ?? 0
        ]
);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-产品列表-->
        <div class="right-box">
            <div class="detail-info">
                <div class="fl-img">
                    <img src="{{ $product_images[0]['url'] or '/www/images/provider/default_logo.png' }}">
                </div>
                <div class="fr-info">
                    <p class="title">{{ $name or '' }}</p>
                    <p class="price">市场参考价：<span>￥{{ $price_low or '' }}~{{ $price_high or '' }}</span></p>
                    <div class="product-collection-box">
                        @if($has_collected)
                            <a href="javascript:;" class="close-product-collection" data-id="{{$id or 0}}">已收藏</a>
                        @else
                            <a href="javascript:;" class="product-collection" data-id="{{$id or 0}}">加入收藏</a>
                        @endif
                    </div>
                </div>
            </div>
            <h3>产品参数</h3>
            @if(!empty($attrib_array))
                <ul class="product-box">
                    @foreach($attrib_array ?? [] as $attrib)
                        <li class="product-category">
                            <span>{{ $attrib['name'] ?? '' }}</span>
                            <ul>
                                @foreach($attrib['nodes'] ?? [] as $node)
                                    <li>{{ $node['name'] }}：{{ $node['value'] ?? '无' }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                @include('common.no-data',['title' => '暂无数据'])
            @endif
        </div>
    </div>

@endsection