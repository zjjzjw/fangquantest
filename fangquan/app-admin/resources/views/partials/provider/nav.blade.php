<?php
$menus = [
        '基本信息'    => [
                'provider.provider.edit'
        ],
        '产品管理'    => [
                'provider.provider-product.index',
                'provider.provider-product.edit'
        ],
        '方案管理'    => [
                'provider.provider-product-programme.index',
                'provider.provider-product-programme.edit'
        ],
        '企业证书'    => [
                'provider.provider-certificate.index',
                'provider.provider-certificate.edit'
        ],
        '服务网点'    => [
                'provider.provider-service-network.index',
                'provider.provider-service-network.edit'
        ],
        '历史项目'    => [
                'provider.provider-project.index',
                'provider.provider-project.edit'
        ],
        '企业动态'    => [
                'provider.provider-news.index',
                'provider.provider-news.edit'
        ],
        '验厂报告'    => [
                'provider.provider-aduitdetails.index',
                'provider.provider-aduitdetails.edit'
        ],
        '战略合作开发商' => [
                'provider.provider-friend.index',
                'provider.provider-friend.edit'
        ],
        '宣传图片、视频' => [
                'provider.provider-propaganda.index',
                'provider.provider-propaganda.edit'
        ]
];
$url_name = request()->route()->getName();
?>
<nav class="navigation-bar">
    <a href="{{route('provider.provider.edit',['id'=>$provider_id])}}"
       @if($url_name == 'provider.provider.edit') class="active" @endif>基本信息</a>

    <a href="{{route('provider.provider-product.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['产品管理']) ) class="active" @endif>产品管理</a>

    <a href="{{route('provider.provider-product-programme.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['方案管理']) ) class="active" @endif>方案管理</a>

    <a href="{{route('provider.provider-certificate.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['企业证书']) ) class="active" @endif>企业证书</a>

    <a href="{{route('provider.provider-service-network.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['服务网点']) ) class="active" @endif>服务网点</a>

    <a href="{{route('provider.provider-project.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['历史项目']) ) class="active" @endif>历史项目</a>

    <a href="{{route('provider.provider-news.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['企业动态']) ) class="active" @endif>企业动态</a>

    <a href="{{route('provider.provider-aduitdetails.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['验厂报告']) ) class="active" @endif>验厂报告</a>

    <a href="{{route('provider.provider-friend.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['战略合作开发商']) ) class="active" @endif>战略合作开发商</a>

    <a href="{{route('provider.provider-propaganda.index',['provider_id' => $provider_id])}}"
       @if(in_array($url_name,$menus['宣传图片、视频']) ) class="active" @endif>宣传图片、视频</a>
</nav>