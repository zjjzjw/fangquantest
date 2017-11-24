<?php
ufa()->extCss([
    'brand/sale-channel/modify'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    'brand/sale-channel/modify'
]);
ufa()->addParam([
    'id' => $brand_id ?? 0,
]);
?>


@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            @include('common.press',['brand_id'=> $provider_id ?? 0])
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('brand.sale-channel.report',['brand_id' => $brand_id ?? 0])}}">报表模式</a>
                </div>
                <div class="add-btn">
                    <a href="{{route('brand.sale-channel.index',[ 'brand_id' => $brand_id ?? 0])}}">列表模式</a>
                </div>
            </div>
            <aside>
                <form id="form" onsubmit="return false">
                    <ul class="sales-type">
                        <li>工程销售金额（万元）</li>
                        <li>电商销售金额（万元）</li>
                        <li>零售销售金额（万元）</li>
                    </ul>
                    @foreach($years as $year => $name)
                        <dl class="sales-box">
                            <dt>
                                {{$year}}

                            </dt>
                            <dd>
                                <input type="hidden" name="sales[year][]" value="{{$year}}">
                                <input type="hidden" name="sales[type][]"
                                       value="{{\App\Src\Brand\Domain\Model\SaleChannelType::BRAND}}">
                                <input type="text" name="sales[amount][]"
                                       value="{{$sales[$year][\App\Src\Brand\Domain\Model\SaleChannelType::BRAND] ?? 0}}"
                                       data-validation="number required length"
                                       data-validation-allowing="float"
                                       data-validation-length="max50"
                                       data-validation-error-msg="请输入工程销售金额(万元)"/>
                            </dd>
                            <dd>
                                <input type="hidden" name="sales[year][]" value="{{$year}}">
                                <input type="hidden" name="sales[type][]"
                                       value="{{\App\Src\Brand\Domain\Model\SaleChannelType::PRODUCT}}">
                                <input type="text" name="sales[amount][]"
                                       value="{{$sales[$year][\App\Src\Brand\Domain\Model\SaleChannelType::PRODUCT] ?? 0}}"
                                       data-validation="number required length"
                                       data-validation-allowing="float"
                                       data-validation-length="max50"
                                       data-validation-error-msg="请输入电商销售金额(万元)"/>
                            </dd>
                            <dd>
                                <input type="hidden" name="sales[year][]" value="{{$year}}">
                                <input type="hidden" name="sales[type][]"
                                       value="{{\App\Src\Brand\Domain\Model\SaleChannelType::INFORMATION}}">
                                <input type="text" name="sales[amount][]"
                                       value="{{$sales[$year][\App\Src\Brand\Domain\Model\SaleChannelType::INFORMATION] ?? 0}}"
                                       data-validation="number required length"
                                       data-validation-allowing="float"
                                       data-validation-length="max50"
                                       data-validation-error-msg="请输入零售销售金额(万元)"/>
                            </dd>
                        </dl>
                    @endforeach

                    <div class="text-center">
                        <input type="submit" class="button save" value="保存">
                        <input type="hidden" name="brand_id" value="{{$brand_id ?? 0}}">
                        <a class="button clone" href="javascript:history.back()">取消</a>
                    </div>
                </form>
            </aside>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection