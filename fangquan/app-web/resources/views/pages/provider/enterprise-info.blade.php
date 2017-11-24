<?php
ufa()->extCss([
        'provider/enterprise-info'
]);
ufa()->extJs([
        'provider/enterprise-info',
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')

    <div class="main-content">
        @include('partials.provider.company-desc-top')
        @if(!empty($propagandas))
           <div class="swiper-container swiper-container1" id="top-pic">
                 <ul class="swiper-wrapper img-box">
                      @foreach($propagandas ?? [] ?? '' as $propaganda)
                     <li class="swiper-slide">
                         <img src="{{ $propaganda['url'] or '' }}">
                     </li>
                      @endforeach
                 </ul>
             </div> 
    @endif
    @include('partials.provider.company-info-left')
    <!--右侧-企业信息-->
        <div class="right-box">
            <div class="enterprise-info">
                <div class="list-content">
                    <div class="parent-title">
                        <h3>基本信息</h3>
                    </div>
                    <ul class="basic-info">
                        <li>
                            <span class="title">公司名称</span>
                            <span class="content">{{$company_name or ''}}</span>
                        </li>
                        <li>
                            <span class="title">企业法人</span>
                            <span class="content">{{$corp or ''}}</span>
                        </li>
                        <li>
                            <span class="title">主营产品</span>
                            <span class="content">@if(!empty($product_category_names)){{$product_category_names}}@else
                                    未知@endif</span>
                        </li>
                        <li>
                            <span class="title">经营模式</span>
                            <span class="content">{{$operation_mode or ''}}</span>
                        </li>
                        <li>
                            <span class="title">成立时间</span>
                            <span class="content">@if(!empty($founding_time)){{$founding_time}}年@else未知@endif</span>
                        </li>
                        <li>
                            <span class="title">员工人数</span>
                            <span class="content">@if(!empty($worker_count)){{$worker_count}}人@else未知@endif</span>
                        </li>
                        <li>
                            <span class="title">年营业额</span>
                            <span class="content">@if(!empty($turnover)){{$turnover}}万元@else未知@endif</span>
                        </li>
                        <li>
                            <span class="title">注册资金</span>
                            <span class="content">@if(!empty(floatval($registered_capital))) {{$registered_capital}}{{$registered_capital_unit}}@else
                                    未公开@endif</span>
                        </li>
                        <li class="produce-address">
                            <span class="title">生产地址</span>
                            <span class="content address">
                                @if(empty($produce_address))
                                    未知
                                @else
                                    {{$produce_address}}
                                @endif
                            </span>
                        </li>
                        <li class="operation-address">
                            <span class="title">经营地址</span>
                            <span class="content address">
                                @if(empty($operation_address))
                                    未知
                                @else
                                    {{$operation_address}}
                                @endif
                            </span>
                        </li>
                        @if(!empty($license_images))
                            <li class="license">
                                <span class="title">营业执照</span>
                                <span class="content">
                                    <a href="{{ current($license_images)['url'] ?? '' }}" target="_blank">查看</a>
                                </span>
                            </li>
                        @endif
                        <li class="bussiness-produce">
                            <span class="title">企业简介</span>
                            <span class="details">
                                <em>
                                    @if(empty($summary))暂无@else <pre style="border: 0;background: transparent">{{$summary}}</pre> @endif
                                </em>
                                <a href="javascript:void(0);" class="open-all open-comm-desc">查看全部&nbsp;&nbsp;
                                    <i class="iconfont">&#xe614;</i>
                                </a>
                            </span>
                        </li>
                    </ul>
                    @if(!empty($factory_images) || !empty($device_images))
                        <div class="line"></div>
                        <div class="parent-title has-image">
                            <h3>工厂设备</h3>
                        </div>
                        @if(!empty($factory_images))
                            <div class="p_imgs factiry-img-box">
                                <img class="factiry-pop-img"
                                     src="{{ current($factory_images)['url'] ?? '' }}">
                                <p>工厂照片</p>
                            </div>
                        @endif
                        @if(!empty($device_images))
                            <div class="p_imgs device-img-box">
                                <img class="device-pop-img"
                                     src="{{ current($device_images)['url'] ?? '' }}">
                                <p>设备照片</p>
                            </div>
                        @endif
                    @endif
                    @if(!empty($structure_images) || !empty($sub_structure_images))
                        <div class="line"></div>
                        <div class="parent-title has-image">
                            <h3>组织架构</h3>
                        </div>
                        @if(!empty($structure_images))
                            <div class="structure-image">
                                <a target="_blank" href="{{ current($structure_images)['url'] ?? ''}}">
                                    <div class="img-link"><i class="iconfont">&#xe6b2;</i><span>总公司部门架构图</span><i
                                                class="iconfont arrow">&#xe610;</i></div>
                                </a>
                            </div>
                        @endif
                        @if(!empty($sub_structure_images))
                            <div class="sub-structure-image">
                                <a target="_blank" href="{{ current($sub_structure_images)['url'] ?? ''}}">
                                    <div class="img-link"><i class="iconfont">&#xe6b2;</i><span>分支机构架构图</span><i
                                                class="iconfont arrow">&#xe610;</i></div>
                                </a>
                            </div>
                        @endif
                    @endif
                    @if(!empty($certificate))
                        <div class="line"></div>
                        <div class="parent-title has-image">
                            <h3>企业证书</h3>
                        </div>
                        <ul class="certificate">
                            @foreach($certificate as $key => $item)
                                <li class="
                                @if($key===1)qualification
                                @elseif($key===2)patent
                                @elseif($key===3)glory
                                @endif" data-index="{{ $key or 0 }}">
                                    <a href="JavaScript:;">
                                        <i class="iconfont">@if($key===1)&#xe956;@elseif($key===2)&#xe619;@elseif($key===3)&#xe684;@endif</i>
                                        <p>{{ $item['name'] or '' }}&nbsp;&nbsp;&nbsp;{{count($item['nodes'] ?? 0)}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($friends))
                        <div class="line"></div>
                        <div class="parent-title has-image">
                            <h3>战略合作开发商</h3>
                        </div>
                        <div class="developer">
                            @if(1)
                                <a href="JavaScript:;" class="swiper-button-next">
                                   >
                                </a>
                            @endif
                            @if(1)
                                <a href="JavaScript:;" class="swiper-button-prev">
                                    <
                                </a>
                            @endif
                            <div class="swiper-container swiper-container2 provider-friends-box">
                                <ul class="swiper-wrapper lb_ul">
                                    @for($li = 0 ; $li < intval(ceil(count($friends) / 4)); $li ++)
                                        <li  class="swiper-slide">
                                            @for($img = $li * 4; $img < ($li + 1) * 4 && $img < count($friends); $img++)
                                                <img src="{{ $friends[$img]['logo_url'] or 'http://img.fq960.com/FhXe65iaL2i_AIsXnMpFKfU7tEEt' }}">
                                            @endfor
                                        </li>
                                    @endfor

                                </ul>
                            </div>
                        </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script type="text/html" id="factiryTpl">
        <div class="factiry-detail">
            <div class="close-factiry-box close-box">
                <a href="javascript:;">
                    <span class="close-btn">X</span>
                </a>
            </div>
            <div id="factiry-swiper-box" class="swiper-common">
                <div id="play" class="big-images">
                    <ul class="img_ul factiry-slide">
                        @foreach($factory_images ?? [] as $item)
                            <li>
                                <a class="img_a">
                                    <img src="{{$item['url']}}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="javascript:void(0)" class="prev_a change_a" title="上一张"><span></span></a>
                    <a href="javascript:void(0)" class="next_a change_a" title="下一张"><span
                                style="display:block;"></span></a>
                </div>
                <div class="img_hd small-images">
                    <div class="report-thumb">
                        <ul class="clearfix">
                            @foreach($factory_images ?? [] as $item)
                                <li>
                                    <a class="img_a">
                                        <img src="{{$item['url']}}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a class="bottom_a prev_a" style="opacity:0.7;"><i class="iconfont icon-left">&#xe644;</i></a>
                    <a class="bottom_a next_a" style="opacity:0.7;"><i class="iconfont icon-right">&#xe644;</i></a>
                </div>
            </div>
        </div>
    </script>

    <script type="text/html" id="deviceTpl">
        <div class="device-detail">
            <div class="close-device-box close-box">
                <a href="javascript:;">
                    <span class="close-btn">X</span>
                </a>
            </div>
            <div id="device-swiper-box" class="swiper-common">
                <div id="play" class="big-images">
                    <ul class="img_ul device-slide">
                        @foreach($device_images ?? [] as $item)
                            <li>
                                <a class="img_a">
                                    <img src="{{$item['url']}}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="javascript:void(0)" class="prev_a change_a" title="上一张"><span></span></a>
                    <a href="javascript:void(0)" class="next_a change_a" title="下一张"><span
                                style="display:block;"></span></a>
                </div>
                <div class="img_hd small-images">
                    <div class="report-thumb">
                        <ul class="clearfix">
                            @foreach($device_images ?? [] as $item)
                                <li>
                                    <a class="img_a">
                                        <img src="{{$item['url']}}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a class="bottom_a prev_a" style="opacity:0.7;"><i
                                class="iconfont icon-left">&#xe644;</i></a>
                    <a class="bottom_a next_a" style="opacity:0.7;"><i class="iconfont icon-right">&#xe644;</i></a>
                </div>
            </div>
        </div>
    </script>
    <script type="text/html" id="certificateTpl">
        @foreach($certificate as $p =>$items)
        <div class="certificate-detail" data-index="{{$p}}" style="display: none;">
            <div class="close-certificate-box close-box">
                <a href="javascript:;">
                    <span class="close-btn">X</span>
                </a>
            </div>
            <div id="certificate-swiper-box" class="swiper-common">
                <div id="play" class="big-images">
                    <ul class="img_ul certificate-slide">
                        @foreach($items['nodes'] as $item)
                            <li>
                                <a class="img_a">
                                    <img src="{{$item['image_url']}}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="javascript:void(0)" class="prev_a change_a" title="上一张"><span></span></a>
                    <a href="javascript:void(0)" class="next_a change_a" title="下一张"><span
                                style="display:block;"></span></a>
                </div>
                <div class="img_hd small-images">
                    <div class="report-thumb">
                        <ul class="clearfix">
                            @foreach($items['nodes'] as $item)
                                <li>
                                    <a class="img_a">
                                        <img src="{{$item['image_url']}}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a class="bottom_a prev_a" style="opacity:0.7;"><i
                                class="iconfont icon-left">&#xe644;</i></a>
                    <a class="bottom_a next_a" style="opacity:0.7;"><i class="iconfont icon-right">&#xe644;</i></a>
                </div>
            </div>
        </div>
        @endforeach
    </script>
@endsection