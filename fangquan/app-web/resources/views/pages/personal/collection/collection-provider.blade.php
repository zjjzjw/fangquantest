<?php
ufa()->extCss([
    'personal/collection/collection-provider'
]);
ufa()->extJs([
    'personal/collection/collection-provider'
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
                        <input type="text" name="keyword" class="search_bar" placeholder="搜索供应商"
                               value="{{$appends['keyword'] ?? ''}}">
                        <input type="submit" class="search-btn" value="查询">
                    </form>
                </div>
                @if(!empty($items))
                    <div class="list-item">
                        <p>
                            <span>品牌</span>
                            <span>公司名称</span>
                            <span>主营产品</span>
                            <span>所在地</span>
                        </p>
                        <ul>
                            @foreach($items as $item)
                                <li>
                                    <a target="_blank"
                                       href="{{route('provider.enterprise-info', ['provider_id' => $item['id']])}}">
                                        <div class="logo-img">
                                            <img src="{{$item['logo_images'][0]['url'] ?? ''}}" alt="logo">
                                        </div>
                                        <span>{{$item['company_name'] or ''}}</span>
                                        <span>{{$item['provider_main_category'] or ''}}</span>
                                        <span>{{$item['produce_province_name'] or ''}}{{$item['produce_city_name'] or ''}}</span>
                                    </a>
                                    <span data-id="{{$item['id']}}" class="delete">
                                <i class="iconfont">&#xe65d;</i>
                            </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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