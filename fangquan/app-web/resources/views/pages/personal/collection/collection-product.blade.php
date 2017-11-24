<?php
ufa()->extCss([
    'personal/collection/collection-product'
]);
ufa()->extJs([
    'personal/collection/collection-product'
]);
ufa()->addParam(['token' => csrf_token()]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        @include('pages.personal.personal-left')
        <div class="right-box">
            @include('pages.personal.collection.nav')
            <div class="tab_box">
                <div class="search">
                    <form action="" method="get">
                        <input type="text" name="keyword" class="search_bar" placeholder="搜索产品"
                               value="{{$appends['keyword'] or ''}}">
                        <input type="submit" class="search-btn" value="查询">
                    </form>
                </div>
                <p class="categories">
                    <span>产品分类:</span>
                    @foreach($search_categories as $key => $name)
                        <a href="{{route('personal.collection.collection-product').'?second_product_category_id='.$key}}"
                           @if(($appends['second_product_category_id'] ?? 0) == $key)
                           class="curr"
                                @endif
                        >{{$name['name'] or ''}}({{$name['count'] or 0}})</a>
                    @endforeach
                </p>
                @if(!empty($items))

                    <ul class="list-item">
                        @foreach($items as $item)
                            <li>
                                <a target="_blank"
                                   href="{{route('provider.product-scheme.product.detail',['provider_id' => $item['provider_id'], 'provider_product_id' => $item['id']])}}">
                                    <img src="{{$item['product_images'][0]['url'] or ''}}?imageView2/1/w/214/h/160"
                                         alt=""
                                         class="img-box">
                                    <p class="title">{{$item['name'] or ''}}</p>
                                    <p class="reference-price">参考价格</p>
                                    <p class="price">￥ {{$item['price_low'] or 0}}～{{$item['price_high'] or 0}}</p>
                                </a>
                                {{--<a href="JavaScript:void(0);" class="contrast">VS 对比</a>--}}
                                <a href="JavaScript:;" class="delete" data-id="{{$item['id']}}">
                                    <i class="iconfont">&#xe65d;</i>
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
                    @include('common.no-data', ['title' => '暂无数据'])
                @endif
            </div>
        </div>
    </div>
    @include('common.back-top')
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection