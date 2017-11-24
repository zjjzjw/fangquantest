<?php
ufa()->extCss([
    'brand/brand-sales/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'brand/brand-sales/edit'
]);
ufa()->addParam([
    'id'       => $id ?? 0,
    'brand_id' => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">负责区域新增</p>
                @else
                    <p class="top-title">负责区域编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">区域类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择属性">
                                <option value="">--选择区域类型--</option>
                                @foreach($brand_sale_type as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($type ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">姓名：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}" placeholder="请输入姓名"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入姓名"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系方式：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="telphone" value="{{$telphone or ''}}" placeholder="请输入联系方式"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入联系方式"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">负责区域：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 10px">
                            <div class="charge">
                                @foreach($brand_sale_area_type as $key => $value)
                                    <input name="sale_areas[]" id="checkbox{{$key}}"
                                           type="checkbox"
                                           @if(in_array($key, $sale_areas ?? [])) checked @endif
                                           value="{{$key}}"/>
                                    <label for="checkbox{{$key}}">{{$value}}</label>
                                @endforeach
                                <p class="error-tip-sale_areas error-tip" style="display: none;">请至少选择一项</p>
                            </div>
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