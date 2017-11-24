<?php
ufa()->extCss([
        'provider/provider-propaganda/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-propaganda/edit'
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
                    <p class="top-title">宣传图片,视频添加</p>
                @else
                    <p class="top-title">宣传图片,视频编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">链接地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="link" value="{{$link or ''}}"
                                   id="url"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加链接地址"/>
                            <p class="error-url" style="display: none;">请填写正确的链接地址</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">选择图片：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name' => 'image_id',
                                    'images' => $images ?? [],
                                ])
                                <p class="error-tip-imageId error-tip" style="display: none;">请上传图片</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="hidden" name="provider_id" value="{{$provider_id ?? 0}}">
                        <input type="submit" class="button small-width save" value="保存">
                        <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.add-picture-item')
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection