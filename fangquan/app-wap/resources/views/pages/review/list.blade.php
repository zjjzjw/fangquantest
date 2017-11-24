<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/review/list')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/review/list')); ?>
@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        <div class="content-box">
            @include('partials.exhibition-h5.header')
            <div class="activity-content">
                <ul class="activity">
                    @foreach(($items ?? []) as $item)
                        @if( $item['images_count'] == 0)
                            <li class="no-img">
                                <a href="{{route('review.detail', ['id' => $item['id']])}}">
                                    <div class="active-title">
                                        <p>{{$item['title'] or ''}}</p>
                                        <p>{{$item['publish_at'] or ''}}</p>
                                    </div>
                                </a>
                            </li>
                        @elseif($item['images_count'] == 1)
                            <li class="is-img">
                                <a href="{{route('review.detail', ['id' => $item['id']])}}">
                                    <div class="img-box">
                                        @foreach($item['thumbnail_images'] as $image)
                                            <img src="{{$image['url'] or ''}}">
                                        @endforeach
                                    </div>

                                    <div class="active-title">
                                        <p>{{$item['title'] or ''}}</p>
                                        <p>{{$item['publish_at'] or ''}}</p>
                                    </div>
                                </a>
                            </li>

                        @elseif($item['images_count'] >1)
                            <li class="is-imgs">
                                <a href="{{route('review.detail', ['id' => $item['id']])}}">
                                    <div class="active-title">
                                        <p>{{$item['title'] or ''}}</p>
                                    </div>
                                    <div class="img-box">
                                        @foreach($item['thumbnail_images'] as $image)
                                            <img src="{{$image['url'] or ''}}">
                                        @endforeach
                                    </div>
                                </a>
                            </li>
                        @else
                        @endif
                    @endforeach
                </ul>
                @if(count($items) == 10)
                    <a href="javascript:void(0);" class="show-more">更多</a>
                @endif
            </div>
            @include('partials.exhibition-h5.footer')
        </div>
    </div>

    @include('common.loading-pop')

    <script type="text/html" id="show_moreTpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
            <% if(data.items[k].images_count == 0) { %>
        <a href="/review/detail/<%=data.items[k].id%>">
               <li class="no-img">
                    <div class="active-title">
                       <p><%=data.items[k].title%></p>
                       <p><%=data.items[k].publish_at%></p>
                    </div>
                </li>
                </a>
            <% } else if(data.items[k].images_count  == 1) { %>
             <a href="/review/detail/<%=data.items[k].id%>">
                <li class="is-img">
                    <div class="img-box">
                        <% for(var j = 0 ; j < data.items[k].thumbnail_images.length ; j++ ) { %>
                          <img src="<%=data.items[k].thumbnail_images[j].url%>">
                        <% } %>
                    </div>

                    <div class="active-title">
                        <p><%=data.items[k].title%></p>
                        <p><%=data.items[k].publish_at%></p>
                    </div>
                </li>
                </a>
            <% } else if(data.items[k].images_count > 1) { %>
             <a href="/review/detail/<%=data.items[k].id%>">
                <li class="is-imgs">
                    <div class="active-title">
                        <p><%=data.items[k].title%></p>
                    </div>
                    <div class="img-box">
                        <% for(var j = 0 ; j < data.items[k].thumbnail_images.length ; j++ ) { %>
                           <img src="<%=data.items[k].thumbnail_images[j].url%>">
                        <% } %>
                    </div>
                </li>
                </a>
            <% }%>
        <% } %>
    </script>
@endsection