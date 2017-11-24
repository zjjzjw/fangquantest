<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/station/contact')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/station/contact')); ?>
@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        <div class="content-box">
            @include('partials.exhibition-h5.header')
            <ul class="contact">
                <li>名称：中国建材市场协会工程招标采购分会</li>
                <li>地址：北京市丰台区杜家坎南路9号亿旺家居B座四层</li>
                <li>电话：137 8899 2178</li>
                <li>邮箱：bmp1206@caigouxiehui.com</li>
            </ul>
            @include('partials.exhibition-h5.footer')
        </div>
    </div>
@endsection