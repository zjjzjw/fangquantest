<?php
ufa()->extCss([
    'developer/project-category/edit'
]);
ufa()->extJs([
    'developer/project-category/edit',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
]);
ufa()->addParam(['id' => $id ?? 0,
]);

?>
@extends('layouts.master')
@section('master.content')
    <div class="wrap-content">
        <div id="contain">
            @if(empty($id))
                <p class="top-title">添加</p>
            @else
                <p class="top-title">编辑</p>
            @endif
            <form id="form" onsubmit="return false">

                <div class="row">
                    <div class="columns">
                        <label>分类名称：</label>
                        <input class="name" type="text" name="name" value="{{ $name or '' }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="columns">
                        <label>排序：</label>
                        <input class="rank" type="text" name="sort" value="{{ $sort or '' }}"/>
                    </div>
                </div>

                <div class="row main-protect">
                    <div class="columns">
                        <label>参数：</label>
                        <div class="product-attribute-box">

                            <ul class="product-attribute-list">
                                @if(!empty($attribfield_light))
                                    <?php $index = 0; ?>
                                    @foreach($attribfield_light ?? [] as $key => $attribfield_light_item)
                                        <p class="{{$attribfield_light_item['name'] or '' }}">
                                            <span>{{$attribfield_light_item['name'] or '' }}</span>
                                            <em class="delete-parent">:&nbsp;&nbsp;x</em>
                                            <i data-index="{{$index}}" class="iconfont edit-icon">&#xe626;</i>
                                            <i data-index="{{$index}}" class="iconfont add-icon">&#xe602;</i>
                                        </p>
                                        <input type="hidden" name="project[category-param-name][]"
                                               value="{{$attribfield_light_item['name'] or ''}}">
                                        <input type="hidden" name="project[category-param-key][]"
                                               value="{{$attribfield_light_item['key'] or ''}}">
                                        @foreach($attribfield_light_item['nodes'] ?? [] as $node)
                                            <li class="{{$attribfield_light_item['name'] or '' }}">
                                                <span>{{ $node['name'] or ''}}</span><em class="delete">x</em><i
                                                        class="iconfont edit-icon">&#xe626;</i>
                                                <input type="hidden"
                                                       name="project[category-param{{$index}}][param-name][]"
                                                       data-index="{{$index}}" value="{{$node['name'] or ''}}">
                                                <input type="hidden"
                                                       name="project[category-param{{$index}}][param-key][]"
                                                       data-index="{{$index}}" value="{{$node['key'] or ''}}">
                                            </li>
                                        @endforeach
                                        <?php $index++; ?>
                                    @endforeach
                                @endif
                            </ul>

                            <div class="textarea-select product-attribute" contenteditable="true">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="columns">
                        <label>描述：</label>
                        <textarea rows="5" name="description">{{ $description or '' }}</textarea>
                    </div>
                </div>

                <div class="row judge">
                    <label>是否显示：</label>
                    <div class="option">
                        <input type="radio" name="status" value="1" id="checkbox-first"
                               @if(($status ?? 1) == 1) checked @endif/>
                        <label for="checkbox-first">是</label>
                        <input type="radio" name="status" value="2" id="checkbox-second"
                               @if(($status ?? 0) == 2) checked @endif/>
                        <label for="checkbox-second">否</label>
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 columns text-right">
                        <label class="text-right">logo：</label>
                    </div>
                    <div class="small-14 columns upload-img">
                        <div class="img-box">
                            @include('common.add-picture', [
                                'single' => true,
                                'tips' => '上传图片',
                                'name' => 'logo',
                                'images' => $thumbnail_images ?? [],
                            ])
                        </div>
                        <p class="error-tip-picture error-tip" style="display: none;">请上传logo图片</p>
                    </div>
                </div>

                <div class="row">
                    <div class="columns">
                        <label>icon：</label>
                        <input class="rank" type="text" name="icon_font" value="{{ $icon_font or '' }}"/>
                    </div>
                </div>


                <div class="text-center">
                    <p class="error-tips"></p>
                    <input type="hidden" name="category" value="">
                    <input type="hidden" name="parent_key" value="">
                    <input type="hidden" name="level" value="{{ $level or 0 }}">
                    <input type="hidden" name="parent_id" value="{{ $parent_id or 0 }}">
                    <input type="hidden" name="id" value="{{ $id or 0 }}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
    @include('common.product-attribute-pop')
    @include('common.add-picture-item')
    @include('common.edit-pop')
@endsection