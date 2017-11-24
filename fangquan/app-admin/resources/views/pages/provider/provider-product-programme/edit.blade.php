<?php
ufa()->extCss([
        'provider/provider-product-programme/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-product-programme/edit',
]);
ufa()->addParam(['id'               => $id ?? 0,
                 'provider_id'      => $provider_id ?? 0,
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' =>$provider_id ?? 0])
        <div class="content-box">

            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">方案添加</p>
                @else
                    <p class="top-title">方案编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">方案标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{$title or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入方案标题">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">关联产品：</label>
                        </div>
                        <div class="small-14 columns">
                            <ul class="list">
                                @foreach(($provider_product_lists ?? []) as $provider_product_list)
                                <li>
                                    <input name="product[]" type="checkbox" value="{{$provider_product_list['id'] ?? 0}}" class="type-detail" id="type{{$provider_product_list['id'] ?? 0}}"
                                           @if(in_array($provider_product_list['id'], $product ?? []))
                                           checked
                                           @endif
                                    >
                                    <label for="type{{$provider_product_list['id'] ?? 0}}">{{$provider_product_list['name'] ?? ''}}</label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">方案图片：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name' => 'provider_product_programme_images',
                                    'images' => $programme_images  ?? [],
                                ])
                            </div>
                            <p class="error-tip-provider_product error-tip" style="display: none;">请上传方案图片</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">方案描述：</label>
                        </div>
                        <div class="small-14 columns">
                            <textarea name="desc" class="textarea-content"
                                   data-validation="required" data-validation-allowing="float"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入方案描述">{{$desc or ''}}</textarea>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="hidden" name="attrib" value="">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id or 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>

@include('common.success-pop')
@include('common.loading-pop')
@include('common.add-picture-item')
@include('common.prompt-pop',['type'=>1])
@endsection
