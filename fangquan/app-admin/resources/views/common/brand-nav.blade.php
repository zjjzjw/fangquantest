<?php
$menus = [
        '基本信息'     => [
                'brand.edit'
        ],
        '项目清单'     => [
                'brand.brand-sign.index',
                'brand.brand-sign.edit'
        ],
        '认证证书'     => [
                'brand.brand-certificate.index',
                'brand.brand-certificate.edit'
        ],
        '厂家管理'     => [
                'brand.brand-factory.index',
                'brand.brand-factory.edit'
        ],
        '销售负责人'    => [
                'brand.brand-sales.index',
                'brand.brand-sales.edit'
        ],
        '定制化产品、服务' => [
                'brand.custom-product.index',
                'brand.custom-product.edit'
        ],
        '战略合作客户'   => [
                'brand.cooperation.index',
                'brand.cooperation.edit'
        ],
        '渠道销售额'    => [
                'brand.sale-channel.index',
                'brand.sale-channel.edit',
                'brand.sale-channel.modify'
        ],
        '补充资料'     => [
                'brand.supplementary.index',
                'brand.supplementary.edit'
        ]
];
$url_name = request()->route()->getName();

?>

<nav class="navigation-bar">
    <a href="{{route('brand.edit',['id'=> $brand_id ?? 0])}}"
       @if($url_name == 'brand.edit') class="active" @endif>
        <img src="/www/images/press.png" alt="">基本信息</a>

    <a href="{{route('brand.brand-service.edit',['brand_id'=> $brand_id ?? 0])}}"
       @if($url_name == 'brand.brand-service.edit') class="active" @endif>
        @if(!empty($brand_progress['brand_service'])) <img src="/www/images/press.png" alt=""> @endif 服务体系</a>

    <a href="{{route('brand.cooperation.index', ['brand_id'=> $brand_id ?? 0])}}"
       @if($url_name == 'brand.cooperation.index') class="active" @endif>
        @if(!empty($brand_progress['brand_cooperation'])) <img src="/www/images/press.png" alt=""> @endif 战略合作客户</a>

    <a href="{{route('brand.brand-sign.index', ['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['项目清单']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_sign_list'])) <img src="/www/images/press.png" alt=""> @endif 项目清单</a>

    <a href="{{route('brand.brand-certificate.index',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['认证证书']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_certificate'])) <img src="/www/images/press.png" alt=""> @endif 认证证书</a>

    <a href="{{route('brand.brand-factory.index',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['厂家管理']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_factory']))<img src="/www/images/press.png" alt=""> @endif 厂家管理</a>

    <a href="{{route('brand.brand-sales.index',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['销售负责人']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_sale'])) <img src="/www/images/press.png" alt=""> @endif 销售负责人</a>
    <a href="{{route('brand.custom-product.index',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['定制化产品、服务']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_custom_product'])) <img src="/www/images/press.png" alt=""> @endif
        定制化产品、服务</a>

    <a href="{{route('brand.sale-channel.modify',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['渠道销售额']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_sale_channel']))<img src="/www/images/press.png" alt=""> @endif 渠道销售额</a>

    <a href="{{route('brand.supplementary.index',['brand_id'=> $brand_id ?? 0])}}"
       @if(in_array($url_name,$menus['补充资料']) ) class="active" @endif>
        @if(!empty($brand_progress['brand_supplementary'])) <img src="/www/images/press.png" alt=""> @endif 补充资料</a>
</nav>