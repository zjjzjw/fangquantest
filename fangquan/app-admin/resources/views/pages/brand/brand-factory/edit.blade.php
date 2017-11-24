<?php
ufa()->extCss([
    'brand/brand-factory/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'brand/brand-factory/edit'
]);
ufa()->addParam([
    'id'          => $id ?? 0,
    'areas'       => $areas ?? [],
    'province_id' => $province_id ?? 0,
    'city_id'     => $city_id ?? 0,
    'unit'     => $unit ?? 0,
    'brand_id'    => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">厂家管理新增</p>
                @else
                    <p class="top-title">厂家管理编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="factory_type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择属性">
                                <option value="">--选择类型--</option>
                                @foreach($brand_factory_type as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($factory_type ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">经营地址：</label>
                        </div>
                        <div class="small-14 columns areas">
                            <div class="inline-areas">
                                <select name="province_id" id="province_id"
                                        data-validation="required"
                                        data-validation-error-msg="请选择省份"></select>
                            </div>
                            <div class="inline-areas">
                                <select name="city_id" id="city_id"
                                        data-validation="required"
                                        data-validation-error-msg="请选择城市"></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">经营详细地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="address" value="{{$address or ''}}"
                                   data-validation="length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入经营地址"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">生产面积：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="production_area" value="{{$production_area or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入生产面积"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">面积单位：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="unit"
                                    data-validation="required"
                                    data-validation-error-msg="请选择是否独家">
                                <option value="">--选择--</option>
                                @foreach($unit_arr as  $value)
                                    <option value="{{$value}}"
                                            @if(($unit ?? '') == $value) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="brand_id" value="{{$brand_id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection