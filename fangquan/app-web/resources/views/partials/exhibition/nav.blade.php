<?php
$url_name = request()->route()->getName();
?>
<nav class="nav">
    <h3>展会概况</h3>
    <ul>
        <li class="@if($url_name == 'exhibition.introduce') active @endif">
            <a href="{{route('exhibition.introduce')}}">展会介绍</a>
        </li>
        <li class="@if($url_name == 'exhibition.activity') active @endif">
            <a href="{{route('exhibition.activity')}}">重大活动</a>
        </li>
        <li class="@if($url_name == 'exhibition.cooperation') active @endif">
            <a href="{{route('exhibition.cooperation')}}">合作机构媒体</a>
        </li>
        <li class="@if($url_name == 'exhibition.flashback.index' || $url_name == 'exhibition.flashback.detail ' || $url_name == 'exhibition.flashback.audio') active @endif">
            <a href="{{route('exhibition.flashback.index')}}">精彩回顾</a>
        </li>
    </ul>
</nav>
@include('common.back-top')