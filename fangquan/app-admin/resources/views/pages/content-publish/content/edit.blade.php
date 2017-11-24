<?php
ufa()->extCss([
    '../lib/datetimepicker/jquery.datetimepicker',
    'content-publish/content/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'content-publish/content/edit',
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
                    <p class="top-title">内容添加</p>
                @else
                    <p class="top-title">内容编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{$title or ''}}" placeholder="请输入标题"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入标题"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">作者：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="author" value="{{$author or ''}}" placeholder="请输入作者"
                                   data-validation="length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入作者"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">图片：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name'   => 'image',
                                    'images' => $thumbnail_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">视频：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="audio_title" class="audio-title" readonly="true" placeholder="视频名称">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传视频',
                                    'name'   => 'audio',
                                    'images' => $audio_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">URL：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="url" value="{{$url or ''}}" placeholder="请输入URL"
                                   data-validation="length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入URL"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">内容：</label>
                        </div>
                        <div class="small-14 columns">
                            <!-- 加载编辑器的容器 -->
                            @include('UEditor::head')
                            <script id="container" name="content" type="text/plain" style="max-width: 550px;height:200px;">{!! $content or '' !!}</script>
                            <p class="error-tip-content error-tip" style="display: none;">请填写文章内容</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">备注：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="remake" value="{{$remake or ''}}" placeholder="请输入备注"
                                   data-validation="length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入备注"/>
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
                                @foreach(($category_tree ?? []) as $category)
                                    <option value="{{$category['id']}}"
                                    @if(($type ?? 0) == $category['id']) selected @endif
                                >{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">是否定时发送：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 20px">
                            @foreach($timing_publish_type as $key => $name)
                                <p>
                                    <input type="radio" name="is_timing_publish" value="{{$key}}" id="checkbox{{$key}}"
                                           @if(($is_timing_publish ?? 0) == $key) checked @endif
                                    >
                                    <label for="checkbox{{$key}}">{{$name}}</label>
                                </p>
                            @endforeach
                            <p class="error-tip-timing_publish error-tip" style="display: none;">请至少选择1项</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">发布时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="publish_time" value="{{$publish_time or ''}}" class="date" placeholder="请选择发布时间"
                                   data-validation="required"
                                   data-validation-error-msg="请选择发布时间"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">状态：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 20px">
                            @foreach($content_status as $key => $name)
                                <p>
                                    <input type="radio" name="status" value="{{$key}}" id="status{{$key}}"
                                           @if(($status ?? 0) == $key) checked @endif
                                    />
                                    <label for="status{{$key}}">{{$name}}</label>
                                </p>
                            @endforeach
                            <p class="error-tip-status error-tip" style="display: none;">请至少选择1项</p>
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
        @include('common.success-pop')
        @include('common.loading-pop')
        @include('common.add-picture-item')
        @include('common.prompt-pop',['type'=>1])
    </div>
@endsection