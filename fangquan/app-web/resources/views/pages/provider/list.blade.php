<?php
ufa()->extCss([
    'provider/list'
]);
ufa()->extJs([
    'provider/list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        <div class="bannen"></div>
        <div class="list-content">
            <div class="bannen-box">
                <ul class="bannen-logo">
                    @foreach($product_categories as $product_category)
                        <li class="@if(($appends['category_id'] ?? 0) == $product_category['id']) active @endif">
                            <a href="{{route('provider.list',['category_id' => $product_category['id']])}}">
                                <i class="iconfont">{{$product_category['icon'] or ''}}</i>
                                <p>{{$product_category['name'] or ''}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


            <div class="ranking-list">
                <h3>{{$product_category_info['name'] or ''}} · 排行榜</h3>
                @if(!empty($providers))
                    <?php $i = 1;?>
                    @foreach($providers as $key => $items)
                        @if(!empty($items))
                            <div class="top-ranking">
                                <h4>{{$key}}</h4>
                                <ul>
                                    @foreach($items as $item)
                                        <li>
                                            <i class="bg-top @if($i <= 3) bg-top{{$i}} @endif">{{$i}}</i>
                                            <a target="_blank"
                                               href="{{ route('provider.enterprise-info',['provider_id'=> $item['id']]) }}">
                                                <img src="{{$item['logo_url']}}"
                                                     class="top-bannen-logo">
                                            </a>
                                        </li>
                                        <?php $i++; ?>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                @else
                    @include('common.no-data', ['title' => '暂无数据'])
                @endif
            </div>
        </div>

        @if(!empty($ad_providers))
            <div class="right-box">
                <ul>
                    @foreach($ad_providers as $ad_provider)
                        <li>
                            <a href="{{route('provider.enterprise-info',['provider_id' => $ad_provider['id']])}}">
                                <i class="advertisement">广告</i>
                                <img src="{{$ad_provider['logo_url'] or ''}}" class="top-bannen-logo">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include('common.back-top')
    </div>
@endsection