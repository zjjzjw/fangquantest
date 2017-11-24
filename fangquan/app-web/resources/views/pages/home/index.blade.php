<?php
ufa()->extCss([
        'home/index'
]);
ufa()->extJs([
        'home/index'
]);

?>
@extends('layouts.master')
@section('master.content')
    <div class="home-bg">
        <div class="home-top">
            <div class="home-logo">
                <img src="/www/images/home/home-logo.png" alt="">
            </div>
            @if(!isset($basic_data['user']))
                <ul>
                    <li><a href="{{route('register')}}">&nbsp;注册</a></li>
                    <li>|</li>
                    <li><a href="{{route('login')}}">登录&nbsp;</a></li>
                </ul>
            @else
                <ul>
                    <li><a href="{{route('logout')}}">&nbsp;退出</a></li>
                    <li>|</li>
                    <li>
                        <a class="nickname" href="{{route('personal.home')}}">
                            {{$basic_data['user']->nickname or ''}}&nbsp;
                        </a>
                    </li>
                </ul>
            @endif
        </div>
        <div class="wrap-ico">
            追寻，最强开发商、最好供应商
        </div>
        <div class="modular">
            <a target="_blank" href="{{ route('provider.list') }}" class="provider">找TOP20供应商</a>
            <a target="_blank" href="{{ route('developer.developer-project.list') }}" class="project">找百强开发商项目</a>
        </div>
        <!--滚动数据-->
        <div class="scroll">
            <ul class="scroll-box">
                @foreach($developer_projects as $key => $developer_project)
                    <li class="scroll-item">
                        <a target="_blank" href="{{route('developer.developer-project.detail',
                        ['developer_project_id' => $developer_project['id'] ?? 0 ] )}}">
                            @if($developer_project['rank']>3)
                            <i class="top top-img">
                            @else
                            <i class="top{{$developer_project['rank'] ?? 0}} top-img">
                            @endif{{$developer_project['rank'] ?? 0}}</i>
                            <span class="title">{{$developer_project['developer_name']}} 发布了项目</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--搜索-->
        <div id="search-box" class="search-box">
            <div class="search">
                <span class="search-type">找项目</span>
                <form class="search-input" onsubmit="return false;">
                    <div class="content-wrap">
                        <input type="text" name="keyword" placeholder='请输入项目名、百强开发商名' id="keyword" class="keyword" value="">
                        <span class="btn">搜索</span>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="main-info">
        <div class="info-box">
            <ul>
                <li>
                    <div class="info-item">
                        <i class="iconfont sale">&#xe662;</i>
                        <div class="title">百强开发商项目</div>
                        <p>为您提供全国100强开发商的优质项目</p>
                    </div>
                </li>
                <li>
                    <div class="info-item">
                        <i class="iconfont project-ico">&#xe660;</i>
                        <div class="title">提升项目中标率</div>
                        <p>帮您全面了解自己及和竞争对手的优劣势，提升招投标的成功率</p>
                    </div>
                </li>
                <li>
                    <div class="info-item">
                        <i class="iconfont provider-ico">&#xe65f;</i>
                        <div class="title">行业20强供应商</div>
                        <p>为您提供行业前20强建材供应商信息</p>
                    </div>
                </li>
                <li>
                    <div class="info-item">
                        <i class="iconfont product-ico">&#xe661;</i>
                        <div class="title">比选最优产品</div>
                        <p>帮您对比不同品牌的产品和国标参数，选出最优产品</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="entering-brand">
            <div class="title-box">
                <div class="line">
                    <div class="title">
                        入驻品牌
                        <span>已入驻{{$provider_count or 0}}家</span>
                    </div>
                </div>
            </div>
            <div class="brand-box">
                @foreach($providers as $provider)
                    <div class="brand-item">
                        <a target="_blank"
                           href="{{route('provider.enterprise-info', ['provider_id' => $provider['id']])}}">
                            <img src="{{$provider['logo_url'] or ''}}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

@endsection
