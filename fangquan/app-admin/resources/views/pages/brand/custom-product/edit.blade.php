<?php
ufa()->extCss([
    '../lib/autocomplete/autocomplete',
    'brand/custom-product/edit'
]);
ufa()->extJs([
    '../lib/autocomplete/autocomplete',
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    'brand/custom-product/edit',
]);
ufa()->addParam([
    'id'       => $id ?? 0,
    "brand_id" => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">定制化产品、服务新增</p>
                @else
                    <p class="top-title">定制化产品、服务编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">开发商名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="developer_name" value="{{$developer_name or ''}}"
                                   id="developer-keyword" placeholder="请输入开发商名称（下拉联想选择项）"
                                   data-developer_id="{{$developer_id or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入开发商名称（下拉联想选择项）"/>
                            <input type="hidden" name="developer_id" value="{{$developer_id or 0}}">
                            <div class="content-wrap"></div>
                            <p class="error-tip-developer error-tip" style="display: none;">请输入开发商名称（下拉联想选择项）</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">定制产品名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="product_name" value="{{$product_name or ''}}" placeholder="请输入定制产品名称"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入定制产品名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">所用项目楼盘名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="loupan_name" value="{{$loupan_name or ''}}" id="project-keyword"
                                   placeholder="请输入所用项目楼盘名称（下拉联想选择项）"
                                   data-loupan_id="{{$loupan_id or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入所用项目楼盘名称（下拉联想选择项）"/>
                            <input type="hidden" name="loupan_id" value="{{$loupan_id or 0}}">
                            <div class="content-wrap-project"></div>
                            <p class="error-tip-loupan error-tip" style="display: none;">请输入所用项目楼盘名称（下拉联想选择项）</p>
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