<?php
ufa()->extCss([
        'provider/provider-certificate/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-certificate/edit',
]);
ufa()->addParam(['id' => $id ?? 0, 'provider_id' => $provider_id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav', ['provider_id' =>$provider_id ?? 0])
        <div class="content-box">

            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">证书添加</p>
                @else
                    <p class="top-title">证书编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书图片：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name' => 'image_id',
                                    'images' => $images  ?? [],
                                ])
                            </div>
                            <p class="error-tip-imageId error-tip" style="display: none;">请上传产品图片</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入证书名称">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择证书类型">
                                <option value="">--请选择证书类型--</option>
                                @foreach($provider_certificate_types as $key => $name)
                                    <option @if($key == ($type ?? 0)) selected
                                            @endif value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>

        @include('common.add-picture-item')
        @include('common.success-pop')
        @include('common.loading-pop')
        @include('common.prompt-pop',['type'=>1])
    </div>
@endsection