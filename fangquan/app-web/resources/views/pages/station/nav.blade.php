<?php
$url_name = request()->route()->getName();
?>
<nav class="nav">
    <ul>
        <li class="@if($url_name == 'station.about') active @endif">
            <i class="iconfont">&#xe63d;</i>
            <a href="{{route('station.about')}}">关于房圈</a>
        </li>
        <li class="@if($url_name == 'station.contact') active @endif">
            <i class="iconfont">&#xe836;</i>
            <a href="{{route('station.contact')}}">联系我们</a>
        </li>
        <li class=" @if($url_name == 'station.recruitmen') active @endif">
            <i class="iconfont">&#xe78b;</i>
            <a href="{{route('station.recruitmen')}}">帮助中心</a>
        </li>
        <li class="@if($url_name == 'station.agreement') active @endif">
            <i class="iconfont">&#xe62c;</i>
            <a href="{{route('station.agreement')}}">注册协议</a>
        </li>
    </ul>
</nav>
@include('common.back-top')