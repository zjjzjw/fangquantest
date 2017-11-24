<?php
ufa()->extJs([
        'provider/company-desc-top'
]);
ufa()->extCss([
        'provider/company-desc-top'
]);
ufa()->addParam(
        [
                'provider_id' => $provider_id ?? 0
        ]
);
?>
<div class="wrap-width">
    <div class="brand-info">
        <div class="brand-left">
            <div class="company-logo">
                <img src="{{$common_data['logo_url'] or '/www/images/provider/default_logo.png' }}" alt="LOGO">
            </div>
            <span class="title">{{ $common_data['brand_name'] or '' }}</span>
            <div class="company-info">
                <p class="company-name">{{ $common_data['company_name'] or '' }}</p>
                <div class="category-box">
                    @foreach($common_data['product_categories'] ?? [] as $product_categories)
                        <p class="category-names"><span>{{ $product_categories['name'] or '' }}</span></p>
                    @endforeach
                </div>
                <p class="company-detail">
                    <i class="iconfont">&#xe609;</i>
                    <span class="address">
                        {{ $common_data['province']['name'] or '' }} {{ $common_data['city']['name'] or '' }}
                    </span>
                </p>
            </div>
        </div>
        <div class="brand-right">
            @if($common_data['has_collected'])
                <a href="javascript:;" class="close-collection" data-id="{{ $provider_id or 0 }}">
                    <i class="iconfont active">&#xe68c;</i>已收藏
                </a>
            @else
                <a href="javascript:;" class="collection" data-id="{{ $provider_id or 0 }}">
                    <i class="iconfont">&#xe68c;</i>加入收藏
                </a>
            @endif
            @if(0)
                <a href="javascript:;" class="contrast provider-contrast" data-id="{{ $provider_id or 0 }}"><i
                            class="iconfont">&#xe60f;</i>加入对比</a>
            @endif
        </div>
    </div>
    <div class="nav-box">
        <ul>
            <li class="bg-blue">
                @if(str_contains(request()->route()->getName(),'provider.enterprise-info'))
                    <div class="triangle-down-blue triangle-down"></div>
                @endif
                <a href="{{route('provider.enterprise-info', ['provider_id' => $provider_id ?? 0])}}">企业信息</a>
            </li>
            <li class="bg-red">
                @if(str_contains(request()->route()->getName(),'provider.business-info'))
                    <div class="triangle-down-red triangle-down"></div>
                @endif
                <a href="{{route('provider.business-info', ['provider_id' => $provider_id ?? 0])}}">工商信息</a>
            </li>
            <li class="bg-orange">
                @if(str_contains(request()->route()->getName(),'provider.history-project'))
                    <div class="triangle-down-orange triangle-down"></div>@endif
                <a href="{{route('provider.history-project', ['provider_id'=> $provider_id ?? 0])}}">历史项目</a>
            </li>

            <li class="bg-green">
                @if(str_contains(request()->route()->getName(),'provider.product-scheme'))
                    <div class="triangle-down-green triangle-down"></div>@endif
                <a href="{{route('provider.product-scheme.product', ['provider_id' => $provider_id ?? 0])}}">产品方案</a>
            </li>

            <li class="bg-dark">
                @if(str_contains(request()->route()->getName(),'provider.service-network'))
                    <div class="triangle-down-dark triangle-down"></div>@endif
                <a href="{{route('provider.service-network', ['provider_id' => $provider_id ?? 0])}}">服务网点</a>
            </li>
        </ul>
    </div>
</div>
@include('common.back-top')
@include('common.login-pop')