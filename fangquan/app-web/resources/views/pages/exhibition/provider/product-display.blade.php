<?php
ufa()->extCss([
        'exhibition/provider/product-display'
]);
ufa()->extJs([
        'exhibition/provider/product-display'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    @include('partials.exhibition.provider.provider-header',['provider' => $provider, 'provider_id' => $provider['id']])
    <div class="provider-box">
        @include('partials.exhibition.provider.provider-left', ['provider' => $provider])
        <div class="provider-right">
            <div class="content-box">
                <div class="base-info">
                    <img src="/www/images/exhibition/WechatIMG16.png" alt="">
                    <div class="details">
                        <p>产品分类</p>
                        <div class="classify-detail">
                            <ul>
                                <li @if(empty($appends['product_category_id']))class="active" @endif>
                                    <a href="{{route('exhibition.provider.product-display',
                                        ['provider_id' => $provider_id, 'product_category_id' => 0])}}">全部</a>
                                </li>
                                @foreach(($categories ?? []) as $category)
                                    <li @if(($appends['product_category_id'] ?? 0) == $category['id'])  class="active" @endif>
                                        <a href="{{route('exhibition.provider.product-display',
                                        ['provider_id' => $provider_id, 'product_category_id' => $category['id']])}}">
                                            {{$category['name'] or ''}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="product-details">
                    <ul>
                        @if(!empty($products['items']))
                            @foreach($products['items'] as $item)
                                <li>
                                    <div class="img-box">
                                        <img src="{{$item['logo_url'] or ''}}" alt="">
                                    </div>
                                    <p title="{{$item['product_model'] or ''}}">{{$item['product_model'] or ''}}</p>
                                    <p>
                                        参考价：<span>{{floatval($item['retail_price'] ?? 0)}}{{$item['price_unit'] or ''}}</span>
                                    </p>
                                </li>
                            @endforeach
                        @else
                            @include('common.no-data', ['title' => '暂无数据'])
                        @endif
                    </ul>
                </div>
            </div>
            @if(!$products['paginate']->isEmpty())
                <div class="patials-paging">
                    {!! $products['paginate']->appends($appends)->render() !!}
                </div>
            @endif
        </div>


    </div>
@endsection