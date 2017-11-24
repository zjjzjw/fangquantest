<?php
ufa()->extCss([
    'msg/user-msg/send',
    '../lib/autocomplete/autocomplete',
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'msg/user-msg/send',
    '../lib/autocomplete/autocomplete',
]);
ufa()->addParam(['id' => $id ?? 0,
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">

            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">发送消息</p>
                @else
                    <p class="top-title">查看消息</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">to：</label>
                        </div>
                        <div class="small-14 columns">
                            @if(!empty($id))
                                <input type="text" id="user_name" name="to_user_name" value="{{$to_user_name or ''}}"
                                       data-validation="required length"
                                       data-validation-length="max255"
                                       data-validation-error-msg="请输入需要发送的用户">
                            @else
                                <input type="text" id="mobile" name="mobile"
                                       data-validation="required length"
                                       data-validation-length="max255"
                                       data-validation-error-msg="请输入需要发送的用户">
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{$title or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入标题">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">图片：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name' => 'msg_images',
                                    'images' => $msg_images  ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">内容：</label>
                        </div>
                        <div class="small-14 columns">
                            <textarea name="content" class="textarea-content"
                                      data-validation="required" data-validation-allowing="float"
                                      data-validation-length="max255"
                                      data-validation-error-msg="请输入方案描述">{{$content or ''}}</textarea>
                        </div>
                    </div>

                </aside>
                @if(empty($id))
                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="submit" class="button save" value="发送">
                        <a class="button clone" href="javascript:history.back()">取消</a>
                    </div>
                @else
                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <a class="button clone" href="javascript:history.back()">返回</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection
