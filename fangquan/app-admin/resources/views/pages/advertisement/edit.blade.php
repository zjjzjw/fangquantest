<?php
ufa()->extCss([
        'advertisement/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'advertisement/edit'
]);

ufa()->addParam(
    [
        'id' => $id ?? 0,
    ]
);
?>




@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">广告添加</p>
                @else
                    <p class="top-title">广告编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{$title or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加标题"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">图片：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                        'single' => true,
                                        'tips' => '上传文件',
                                        'name' => 'image',
                                        'images' => $thumbnail_images ?? [],
                                   ])
                                <p class="error-file error-tip" style="display: none;">请上传图片</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">广告位：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="position" value="{{$position or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加广告位"/>
                        </div>
                    </div>

                    {{--<div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="type" value="{{$type or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加类型"/>
                        </div>
                    </div>--}}

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">链接：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="link" value="{{$link or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加链接"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">排序：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="sort" value="{{$sort or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加排序"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-right">状态：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="status" class="options"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选开发商状态">
                                <option value="">--请选开发商状态--</option>
                                @foreach($advertisement_status as $key => $name)
                                    <option @if($key == ($status ?? 0)) selected
                                            @endif value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
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