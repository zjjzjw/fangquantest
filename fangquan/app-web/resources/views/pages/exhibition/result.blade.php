<?php
ufa()->extCss([
    'exhibition/result'
]);
ufa()->extJs([
    'exhibition/result'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        <div class="nav">
            <a href="{{route('exhibition.result')}}">展会成果</a>
        </div>
        <div class="exhibition-content">
            <div class="top-img">
                <img src="/www/images/home/home-bg1.jpeg"
                     alt="">
            </div>
            <ul class="dynamic">
                @foreach(($items ?? []) as $item)
                    <li>
                        <a href="{{route('exhibition.result-detail', ['id' => $item['id']])}}">
                            <p class="title">{{$item['title'] or ''}}</p>
                            <span class="time">{{$item['publish_at'] or ''}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            @if(count($items) > 9)
                <div class="look-more"><a href="JavaScript:void(0);">更多&nbsp;&nbsp;<i class="iconfont">&#xe614;</i></a>
                </div>
            @endif
        </div>
    </div>
    @include('partials.exhibition.friendly-link')

    <script type="text/html" id="list_tpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
         <li>
            <a href="/exhibition/result-detail/<%=data.items[k].id %>">
                <p class="title"><%=data.items[k].title %></p>
                <span class="time"><%=data.items[k].publish_at %></span>
            </a>
        </li>
        <% } %>
    </script>
@endsection