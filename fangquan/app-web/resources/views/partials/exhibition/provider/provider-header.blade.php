<?php
$route_name = request()->route()->getName();
?>
<div class="info-box">
    <div class="company-box">
        <img src="{{$provider['logo_url'] or ''}}" alt="">
        <div class="company-info">
            <p class="company-name">{{$provider['company_name'] or ''}}</p>
            <p class="company-type">{{$provider['provider_company_type_name'] or  ''}}</p>
            <div class="company-condition">
                <p class="adress">
                    <img src="/www/images/exhibition/adress.png" alt="">
                    {{$provider['province']['name'] or ''}}·{{$provider['city']['name'] or ''}}
                </p>
                <p class="company-product">主营产品：<span>{{$provider['provider_main_category_name']}}</span></p>
            </div>
        </div>
    </div>

    <div class="nav-box">
        <ul>
            <li @if($route_name == 'exhibition.provider.detail') class="active" @endif>
                <a href="{{route('exhibition.provider.detail', ['id' => $provider_id ?? 0])}}">企业信息</a>
            </li>
            <li @if($route_name == 'exhibition.provider.engineer-case') class="active" @endif>
                <a href="{{route('exhibition.provider.engineer-case', ['provider_id' => $provider_id ?? 0])}}">工程案例</a>
            </li>
            <li @if($route_name == 'exhibition.provider.product-display') class="active" @endif>
                <a href="{{route('exhibition.provider.product-display', ['provider_id' => $provider_id ?? 0])}}">产品展示</a>
            </li>
            <li @if($route_name == 'exhibition.provider.service-network') class="active" @endif>
                <a href="{{route('exhibition.provider.service-network', ['provider_id' => $provider_id ?? 0])}}">服务网点</a>
            </li>
        </ul>
    </div>
</div>