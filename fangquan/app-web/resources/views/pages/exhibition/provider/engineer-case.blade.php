<?php
ufa()->extCss([
        'exhibition/provider/engineer-case'
]);
ufa()->extJs([
        'exhibition/provider/engineer-case'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    @include('partials.exhibition.provider.provider-header')
    <div class="provider-box">
        @include('partials.exhibition.provider.provider-left')
        <div class="provider-right">
            <div class="content-box">
                <div class="base-info">
                    <img src="/www/images/exhibition/WechatIMG16.png" alt="">
                </div>
                <p class="case-title">工程案例</p>
                <div class="content-detail">
                    <ul>
                        @if(!empty($provider_sign_list['items']))
                            @foreach($provider_sign_list['items'] as $item)
                                <li>
                                    <p title="{{$item['loupan_name'] or ''}}">{{$item['loupan_name'] or ''}}</p>
                                    <p class="special-span" title="{{$item['developer_names'] or ''}}">
                                        开发商：<span>{{$item['developer_names'] or ''}}</span></p>
                                    <p>所在地：<span>{{$item['city_name'] or ''}}</span></p>
                                    <p class="special-span" title="{{$item['category_names'] or ''}}">
                                        产品类别：<span>{{$item['category_names'] or ''}}</span></p>
                                    <p>产品型号：<span>{{$item['product_model'] or ''}}</span></p>
                                    <p>项目总金额：<span>{{floatval($item['brand_total_amount'] ?? 0)}}万</span></p>
                                    <p>合同签订时间：<span>{{$item['order_sign_time'] or ''}}</span></p>
                                </li>
                            @endforeach
                        @else
                            @include('common.no-data', ['title' => '暂无数据'])
                        @endif
                    </ul>
                </div>
            </div>
            @if(!$provider_sign_list['paginate']->isEmpty())
                <div class="patials-paging">
                    {!! $provider_sign_list['paginate']->appends($appends)->render() !!}
                </div>
            @endif
        </div>


    </div>
@endsection