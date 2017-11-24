<?php
ufa()->extCss([
        'developer/developer/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'developer/developer/edit'
]);

ufa()->addParam(
    [
        'id' => $id ?? 0,
        'provider_id' => $provider_id ?? 0,
    ]
);
?>




@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        {{--@include('provider.nav', ['provider_id' =>$provider_id ?? 0])--}}
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">开发商添加</p>
                @else
                    <p class="top-title">开发商编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加公司名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">logo：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                        'single' => true,
                                        'tips' => '上传文件',
                                        'name' => 'logo',
                                        'images' => $thumbnail_images ?? [],
                                   ])
                                <p class="error-file error-tip" style="display: none;">请上传封面</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-right">开发商状态：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="status" class="options"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选开发商状态">
                                <option value="">--请选开发商状态--</option>
                                @foreach($developer_status as $key => $name)
                                    <option @if($key == ($status ?? 0)) selected
                                            @endif value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">开发商排名：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="rank" value="{{$rank or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加开发商排名"/>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
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