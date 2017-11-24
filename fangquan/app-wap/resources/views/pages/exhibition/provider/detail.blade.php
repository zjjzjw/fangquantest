<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/provider/detail')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/provider/detail')); ?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="provider-box">
        <div class="logo-box">
            <div class="img-box">
                <img src="{{$provider['logo_images'][0]['url'] or ''}}" alt="">
                <p>{{$provider['brand_name'] or ''}}</p>
            </div>

            <div class="list-detail">
                <p>{{$provider['company_name'] or ''}}</p>

                <ul>
                    @foreach(($provider['product_category_names'] ?? []) as $key =>$item)
                        <li style="background-color:{{$item['color'] or ""}}">{{$item['name'] or ""}}</li>
                    @endforeach
                </ul>

                @if(!empty($provider['company_type_name']))
                    <p class="company-type">公司类型：<span>{{$provider['company_type_name'] or ''}}</span></p>
                @endif

            </div>
            @if(!empty($provider['city_name']))
                <p class="address">
                    <img src="/www/image/exhibition/exhibition-h5/address.png" alt="">
                    {{$provider['city_name'] or ''}}
                </p>
            @endif
        </div>
        <div class="clear"></div>
    </div>
    <div class="company-detail">
        <ul>
            <li>企业信息</li>
            <li>
                <span>法人：</span>
                <span>{{$provider['corp'] or ''}}</span>
            </li>
            <li>
                <span>经营模式：</span>
                <span>{{$provider['provider_management_mode_names'] or ''}}</span>
            </li>
            <li>
                <span>成立时间：</span>
                <span>{{$provider['founding_time'] or ''}}年</span>
            </li>
            <li><span>注册资金：</span>
                <span>{{$provider['registered_capital'] or ''}} {{$provider['registered_capital_unit'] or ''}}</span>
            </li>
            <li>
                <span>员工人数：</span>
                <span>{{$provider['worker_count'] or ''}}人</span>
            </li>
            <li>
                <span>生产地址：</span>
                <span>{{$provider['produce_address'] or ''}}</span>
            </li>
            <li>
                <span>经营地址：</span>
                <span>{{$provider['operation_address'] or ''}}</span>
            </li>
            <li class="special-li">企业简介：<i class="summary">{{$provider['summary'] or ''}}</i>
                <a href="javascript:void(0);" style="display: none;" class="open-all open-comm-desc">查看全部 >
                </a>
            </li>
        </ul>
    </div>
    @include('partials.exhibition-h5.developer.developer-footer')
@endsection


