<?php
ufa()->extCss([
    'brand/brand-service/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'brand/brand-service/edit'
]);
ufa()->addParam([
    'id' => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=> $brand_id ?? 0])
        <div class="content-box">
            @include('common.press',['brand_id'=> $provider_id ?? 0])
            <div class="button-box">
                <p class="top-title">服务新增</p>
            </div>
            <aside>
                <form id="form" onsubmit="return false">
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">服务能力范围：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="service_range" value="{{$service_range or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入能力范围"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">质保期限：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="warranty_range" value="{{$warranty_range or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入质保期限"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">服务模式：</label>
                        </div>
                        <div class="small-14 columns">
                            @foreach(($service_types ?? []) as $key => $name)
                                <input type="checkbox" id="checkbox{{$key}}" name="service_model[]"
                                       data-validation="checkbox_group"
                                       value="{{$key}}" data-validation-qty="min1" data_id="{{$key}}"
                                       @if(in_array($key, $service_model ?? [])) checked @endif
                                       data-validation-error-msg="请至少选择一项">
                                <label for="checkbox{{$key}}"> {{$name}}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">服务组织架构图：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '选择数据',
                                    'name' => 'file',
                                    'images' => $files ?? [],
                                ])
                            </div>
                            <p class="error-tip-picture error-tip" style="display: none;">请上传服务组织架构图</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品供货周期：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="supply_cycle" value="{{$supply_cycle or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入产品供货周期"/>
                        </div>
                    </div>
                    <p class="supply-title">填写内容例如：进口产品6个月，工厂同城产品2周</p>
                    <div class="text-center">
                        <input type="submit" class="button save" value="保存">
                        <input type="hidden" name="id" value="{{$brand_id ?? 0}}">
                        <a class="button clone" href="javascript:history.back()">取消</a>
                    </div>
                </form>
            </aside>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection