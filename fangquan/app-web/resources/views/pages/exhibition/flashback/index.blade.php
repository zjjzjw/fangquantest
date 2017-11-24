<?php
ufa()->extCss([
    'exhibition/flashback/index'
]);
ufa()->extJs([
    'exhibition/flashback/index'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.nav')
        <div class="exhibition-content">
            <article>
                <div class="list-content">
                    <h3>
                        <i class="icon">
                            <img src="/www/images/exhibition/001.png" alt="">
                        </i>
                        <span>精彩瞬间</span>
                    </h3>

                    <!-- Swiper -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($jcsj['all_images'] ?? []  as $key => $image)
                                <div class="swiper-slide">
                                    <img src="{{$image['url'] ?? ''}}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="list-content">
                    <h3>
                        <i class="icon">
                            <img src="/www/images/exhibition/002.png" alt="">
                        </i>
                        <span>精彩片刻</span>
                    </h3>
                    <ul class="exhibition-list-box">
                        @foreach($jcpk['items'] ?? '' as $key => $value)
                            <li>
                                <a href="{{route('exhibition.flashback.audio',['id'=>$value['id']])}}">
                                    <img class="firstimage"
                                         src="{{$value['audio_url'].'?vframe/png/offset/0/w/280/h/210' ?? ''}}"
                                         alt="{{$value['title']}}">
                                    <img class="spbtn" src="/www/images/exhibition/btn.png">
                                    <p>{{$value['title']}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="look-more">更多
                        <img src="/www/images/more.png" alt="">
                    </div>
                </div>
                <ul class="dynamic">
                    @if(isset($jcwz))
                        @foreach($jcwz ?? '' as $key => $value)
                            <li>
                                <a href="{{route('exhibition.flashback.detail',['id'=>$value['id']])}}" target="_blank">
                                    <p class="title">{{$value['title']}}</p>
                                    <p class="time">{{$value['publish_at']}}</p>
                                </a>
                            </li>
                        @endforeach
                    @endif

                </ul>
            </article>
        </div>
    </div>
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
    @include('partials.exhibition.friendly-link')

    <script type="text/html" id="list_tpl">
        <% for ( var k = 0; k < data.length; k++ ) { %>

        <li>
            <a href="/exhibition/flashback/audio/<%=data[k].id%>">
                <img class="firstimage" src="<%=data[k].audio_url%>?vframe/png/offset/0/w/280/h/210" alt="<%=data[k].title%>">
                <img class="spbtn" src="/www/images/exhibition/btn.png">
                <p><%=data[k].title%></p>
            </a>
        </li>
        <% } %>
    </script>
@endsection