<?php
ufa()->extCss([
    'media-management/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'media-management/edit',
]);
ufa()->addParam([
    'id' => $id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">合作媒体添加</p>
                @else
                    <p class="top-title">合作媒体编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入标题"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name'   => 'logo',
                                    'images' => $thumbnail_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type"
                                    data-validation="required length"
                                    data-validation-length="max255"
                                    data-validation-error-msg="请选择类型">
                                <option value="">--请选择--</option>
                                @foreach(($media_management_types ?? []) as $key => $media_management_type)
                                    <option value="{{$key}}"
                                            @if(($type ?? 0) == $key) selected @endif
                                    >{{$media_management_type}}</option>
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
        @include('common.success-pop')
        @include('common.loading-pop')
        @include('common.add-picture-item')
        @include('common.prompt-pop',['type'=>1])
    </div>
@endsection