<?php
ufa()->extCss([
        'provider/product-scheme/product-list'
]);
ufa()->extJs([
        'provider/product-scheme/product-list',
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-产品列表-->
        <div class="right-box">
            <div class="choose">
                <a class="choose-active"
                   href="{{ route('provider.product-scheme.product',['provider_id'=>$provider_id ?? 0]) }}">产品</a>
                <a href="{{ route('provider.product-scheme.scheme',['provider_id'=>$provider_id ?? 0]) }}">方案</a>
            </div>
            <div class="product-category">
                <span>产品分类</span>

                @foreach($categories_for_search as $key => $name)
                    <a href="{{ route('provider.product-scheme.product',
                    array_merge($appends, ['second_product_category_id' => $key ])
                    ) }}"
                       class="category-item @if(($appends['second_product_category_id'] ?? 0) == $key) click-active @endif">
                        {{ $name }}
                    </a>
                @endforeach

            </div>

            @if(!empty($items))
                <p class="num">共计<span>&nbsp;{{ $pager['total'] or 0 }}&nbsp;</span>个产品</p>
                <ul class="product-box">

                    @foreach($items as $item)
                        <li>
                            <a href="{{ route('provider.product-scheme.product.detail',
                        ['provider_id' =>$provider_id ,'provider_product_id'=>$item['id']]) }}">
                                <img src="{{ $item['product_image_thumb'] or '' }}">
                                <p class="title">{{ $item['name'] or '' }}</p>
                                <p class="price">市场参考价：<span>￥{{ $item['price_low'] or '' }}
                                        ~{{ $item['price_high'] or '' }}</span></p>
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