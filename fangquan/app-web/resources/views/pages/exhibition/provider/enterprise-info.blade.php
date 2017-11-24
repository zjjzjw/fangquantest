<?php
ufa()->extCss([
        'exhibition/provider/enterprise-info'
]);
ufa()->extJs([
        'exhibition/provider/enterprise-info'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    @include('partials.exhibition.provider.provider-header',['provider' => $provider, 'provider_id' => $provider['id']])
    <div class="provider-box">
        @include('partials.exhibition.provider.provider-left', ['brand_sales' => $brand_sales ?? []])
        <div class="provider-right">
            <div class="img-box">
                <img src="/www/images/exhibition/1510647184938.jpg" alt="">
            </div>
            <div class="content-box">
                <div class="base-info">
                    <img src="/www/images/exhibition/WechatIMG13.png" alt="">
                    <div class="details">
                        <p>基本信息</p>
                        <p>公司名称：<span>{{$provider['company_name'] or  ''}}</span></p>
                        <p>成立时间：<span>{{$provider['founding_time']  or ''}}年</span></p>
                        <p>经营地址：<span>{{$provider['operation_address'] or ''}}</span></p>
                        <p>
                            企业简介：<span class="summary">{{$provider['summary'] or  ''}}</span>
                            <a href="javascript:void(0);" class="open-all open-comm-desc"
                               style="display: none;">查看全部<i class="iconfont">&#xe614;</i></a>
                        </p>
                    </div>
                </div>
                <div class="base-info">
                    <img src="/www/images/exhibition/WechatIMG14.png" alt="">
                    <div class="details">
                        <p>工商信息</p>
                        <table class="table">
                            <tbody>
                            <tr class="thead">
                                <td>法人代表</td>
                                <td>注册资本（{{$provider['registered_capital_unit'] or ''}}）</td>
                                <td>注册时间</td>
                                <td>公司类型</td>
                            </tr>
                            <tr>
                                <td>{{$provider['corp'] or  ''}}</td>
                                <td>{{intval($provider['registered_capital'])}}</td>
                                <td>{{$provider['founding_time']  or ''}}年</td>
                                <td>{{$provider['provider_company_type_name'] or ''}}</td>
                            </tr>
                            <tr class="thead">
                                <td>年营业额（万元）</td>
                                <td>员工人数（人）</td>
                                <td colspan="2">经营模式</td>
                            </tr>
                            <tr>
                                <td>{{$provider['turnover'] or ''}}</td>
                                <td>{{$provider['worker_count'] or ''}}</td>
                                <td colspan="2">{{$provider['provider_management_type_name'] or  ''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="base-info">
                    <img src="/www/images/exhibition/WechatIMG15.png" alt="">
                    <div class="details">
                        <p>企业荣誉</p>
                        <div class="img-detail">
                            @if(!empty($certificate_images))
                                <ul>
                                    @foreach($certificate_images  as $certificate_image)
                                        <li>
                                            <a href="{{$certificate_image}}" target="_blank">
                                                <img src="{{$certificate_image}}?imageView2/1/w/200/h/150"
                                                     alt="">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('common.no-data' ,['title'=>'暂无数据'])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection