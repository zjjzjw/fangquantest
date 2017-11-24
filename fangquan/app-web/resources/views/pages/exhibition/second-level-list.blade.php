<?php
ufa()->extCss([
        'exhibition/second-level-list'
]);
ufa()->extJs([
        'exhibition/second-level-list'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="provider-list">
        <div class="select-box">
            <ul>
                @foreach($second_categories as $second_category)
                    <li @if($second_category['id']== $second_level)class="active"@endif>
                        <a href="{{route('exhibition.provider.second-level',
                        ['parent_id' => $parent_id, 'second_level' => $second_category['id']])}}">
                            @if(!empty($second_category['icon_font']))
                                <i class="iconfont">{{$second_category['icon_font']}}</i>
                            @else
                                <img src="{{$second_category['logo_url'] or ''}}" alt="">
                            @endif
                            <p>{{$second_category['name'] or ''}}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!--一级不展示-->
        <div class="img-box">
            <div class="title">
                <p>供应商</p>
            </div>
            <div class="provider-box">

                @if(!empty($providers))
                    <ul>
                        @foreach($providers as $provider)
                            <li class="brand-item">
                                <a target="_blank"
                                   href="{{route('exhibition.provider.detail', ['id' => $provider['id']])}}">
                                    <img src="{{$provider['logo_url'] or ''}}" alt="">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @if(false)<a class="look-more" href="">更多></a>@endif
                @else
                    @include('common.no-data', ['title' => '暂无数据'])
                @endif

            </div>
            <div class="line"></div>
        </div>
    </div>
    @include('partials.exhibition.cooperation-unit')
    @include('partials.exhibition.friendly-link')
@endsection