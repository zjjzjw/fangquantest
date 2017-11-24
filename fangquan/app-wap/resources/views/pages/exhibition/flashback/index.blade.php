<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/flashback/index')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/flashback/index')); ?>

@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        @include('partials.exhibition-h5.header')
        <nav class="nav">
            <ul>
                <li>
                    <a href="JavaScript:void(0);" class="cut introduce">展会介绍</a>
                    <div class="content-box">
                        {!! $introduce or  '' !!}
                    </div>
                </li>
                <li>
                    <a href="JavaScript:void(0);" class="cut activity">重大活动</a>
                    <div class="content-box">
                        {!! $activity or ''  !!}
                    </div>
                </li>
                <li>
                    <a href="JavaScript:void(0);" class="cut cooperation">合作机构媒体</a>
                    <div class="cooperation">
                        <div class="content-box">
                            <div class="box-item organization">
                                <h3>合作机构</h3>
                                <ul>
                                    <li>
                                        <img src="/www/image/exhibition/exhibition-h5/WechatIMG133.jpeg">
                                        <p>主办单位：中国建材市场协会工程招标采购分会</p>
                                    </li>
                                    <li>
                                        <img src="/www/image/exhibition/exhibition-h5/WechatIMG135.jpeg">
                                        <p>协办单位：上海绘房信息科技有限公司</p>
                                    </li>
                                    <li>
                                        <img src="/www/image/exhibition/exhibition-h5/WechatIMG134.jpeg">
                                        <p>承办单位：上海檐宇信息咨询有限公司</p>
                                    </li>
                                    <li id="special">
                                        <img src="/www/image/exhibition/exhibition-h5/WechatIMG136.jpeg" alt="">
                                        <p>全程战略合作：方太集团</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="box-item">
                                @foreach(($media_list ?? []) as $media)
                                    <h3>{{$media['type_name'] or  ''}}</h3>
                                    <ul>
                                        @foreach(($media['list'] ?? []) as $item)
                                            <li>
                                                <img src="{{$item['image_url'] or ''}}">
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="JavaScript:void(0);" class="cut">精彩回放</a>
                    <div class="content-box">

                                    <div class="flashback">
                            <div class="box-item">
                                <h3>精彩瞬间</h3>
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(($jcsj['all_images'] ?? []) as $sj)
                                            <div class="swiper-slide">
                                                <img src="{{$sj['url'] or ''}}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="box-item">
                                <h3>精彩片刻</h3>
                                <ul class="show-more-list">
                                    @foreach(($jcpk['items'] ?? []) as $pk)
                                        <li>
                                            <a href="{{route('exhibition.flashback.audio', ['id' => $pk['id']])}}">
                                                <img class="firstimage"
                                                     src="{{$pk['audio_url'].'?vframe/png/offset/0/w/280/h/210' ?? ''}}"
                                                     alt="{{$pk['title'] or ''}}">
                                                <p>{{$pk['title']}}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="JavaScript:void(0);" class="show-more">更多</a>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>
        </nav>
        @include('partials.exhibition-h5.footer')
    </div>
    @include('common.loading-pop')

    <script type="text/html" id="show_moreTpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
        <li>
            <a href="/exhibition/flashback/audio/<%=data.items[k].id%>">
                <img class="firstimage"
                     src="<%=data.items[k].audio_url + '?vframe/png/offset/0/w/280/h/210'%>"
                     alt="<%=data.items[k].title%>">
                <p><%=data.items[k].title%></p>
            </a>
        </li>
        <% } %>
                </script>
@endsection

