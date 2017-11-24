<?php
ufa()->extCss([
        'provider/product-scheme/scheme-detail'
]);
ufa()->extJs([
        'provider/product-scheme/scheme-detail',
]);
ufa()->addParam(
        [
                'provider_id'        => $provider_id ?? 0,
                'provider_scheme_id' => $id ?? 0
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
                    <img src="{{ $image_url or 'http://img.fq960.com/FhXe65iaL2i_AIsXnMpFKfU7tEEt' }}">
                </div>
                <div class="fr-info">
                    <p class="title">{{ $title or '' }}</p>
                    <p class="price">市场参考价：
                        <span>￥{{ $price_most['most_low'] or 0 }}~{{ $price_most['most_high'] or 0 }}</span>
                    </p>
                    <div class="product-collection-box">
                        @if($has_collected)
                            <a href="javascript:;" class="close-product-collection" data-id="{{$id or 0}}">已收藏</a>
                        @else
                            <a href="javascript:;" class="product-collection" data-id="{{$id or 0}}">加入收藏</a>
                        @endif
                    </div>
                </div>
            </div>
            <h3>方案详情</h3>
            <p class="scheme-detail">
                {{ $desc or '' }}
            </p>
            <h3>该方案包含以下产品</h3>
            <ul class="product-box">
                @foreach($provider_product_info as $item)
                    <li>
                        <a href="{{ route('provider.product-scheme.product.detail',
                        ['provider_id' =>$provider_id ,'provider_product_id'=>$item['id']]) }}">
                            <img src="{{ $item['product_image_url'][0] or 'http://img.fq960.com/FhXe65iaL2i_AIsXnMpFKfU7tEEt?imageView2/1/w/213/h/131' }}">
                            <p class="title">{{ $item['name'] or '' }}</p>
                            <p class="price">
                                市场参考价：<span>￥{{ $item['price_low'] or 0 }}~{{ $item['price_low'] or 0 }}</span>
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection