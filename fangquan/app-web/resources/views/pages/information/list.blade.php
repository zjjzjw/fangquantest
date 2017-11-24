<?php
ufa()->extCss([
    'information/list'
]);
ufa()->extJs([
    'information/list'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="information-list">
        <div class="information-box box-first">
            @foreach(($items ?? []) as $item)
                @if($item['images_count'] == 1)
                    <div class="information-detail">
                        <div class="information-img">
                            <a href="{{route('information.detail', ['id' => $item['id']])}}">
                                <img src="{{$item['thumbnail_images'][0]['url'] or ''}}" alt="">
                            </a>
                        </div>
                        <div class="information-title">
                            <a href="{{route('information.detail', ['id' => $item['id']])}}">
                                <p class="title">{{$item['title'] or ''}}</p>
                            </a>
                            <p class="time">{{$item['publish_at'] or ''}}</p>
                        </div>
                    </div>
                    <div class="clear"></div>
                @elseif($item['images_count'] > 1)
                    <div class="information-box-second">
                        <div class="second-detail">
                            <div class="second-detail-title">
                                <a href="{{route('information.detail', ['id' => $item['id']])}}">
                                    <p class="title">{{$item['title'] or ''}}</p>
                                </a>
                            </div>
                            @foreach($item['thumbnail_images'] as $key => $image)
                                @if($key < 3)
                                <div class="second-img">
                                    <a href="{{route('information.detail', ['id' => $item['id']])}}">
                                        <div class="img-first">
                                            <img src="{{$image['url'] or ''}}" alt="">
                                        </div>
                                    </a>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="clear"></div>
                @else
                <div class="information-box-third">
                    <div class="third-detail">
                        <div class="third-detail-title">
                            <a href="{{route('information.detail', ['id' => $item['id']])}}">
                                <p class="title">{{$item['title'] or ''}}</p>
                            </a>
                        </div>
                        <p class="time">{{$item['publish_at'] or ''}}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @if(count($items) == 15)
        <div class="more-box">更多
            <img src="/www/images/more.png" alt="">
        </div>
        @endif
    </div>
    @include('partials.exhibition.friendly-link')
    @include('common.loading-pop')
    <script type="text/html" id="show_moreTpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
            <% if(data.items[k].images_count == 1){ %>
            <div class="information-detail">
                <div class="information-img">
                    <a  href="/information/detail/<%=data.items[k].id%>"">
                        <img src="<%=data.items[k].thumbnail_images[0].url%>" alt="">
                    </a>
                </div>
                <div class="information-title">
                  <a  href="/information/detail/<%=data.items[k].id%>">
                        <p class="title"><%=data.items[k].title%></p>
                    </a>
                    <p class="time"><%=data.items[k].publish_at%></p>
                </div>
            </div>
            <div class="clear"></div>
            <% } else if(data.items[k].images_count > 1) { %>
            <div class="information-box-second">
                <div class="second-detail">
                    <div class="second-detail-title">
                        <a  href="/information/detail/<%=data.items[k].id%>">
                            <p class="title"><%=data.items[k].title%></p>
                        </a>
                    </div>
                     <% for(var j = 0 ; j < data.items[k].thumbnail_images.length ; j++ ) { %>
                        <% if(j < 3){ %>
                            <div class="second-img">
                                <a  href="/information/detail/<%=data.items[k].id%>">
                                    <div class="img-first">
                                       <img src="<%=data.items[k].thumbnail_images[0].url%>" alt="">
                                    </div>
                                </a>
                            </div>
                         <% } %>
                    <% } %>
                </div>
            </div>
            <div class="clear"></div>
            <% } else  { %>
            <div class="information-box-third">
                <div class="third-detail">
                    <div class="third-detail-title">
                       <a  href="/information/detail/<%=data.items[k].id%>">
                            <p class="title"><%=data.items[k].title%></p>
                        </a>
                    </div>
                    <p class="time"><%=data.items[k].publish_at%></p>
                </div>
            </div>
            <% } %>
        <% } %>
    </script>
@endsection