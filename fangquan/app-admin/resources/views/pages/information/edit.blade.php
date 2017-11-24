<?php
ufa()->extCss([
    '../lib/datetimepicker/jquery.datetimepicker',
    '../lib/autocomplete/autocomplete',
    'information/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/autocomplete/autocomplete',
    '../lib/datetimepicker/jquery.datetimepicker',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'information/edit'
]);
ufa()->addParam([
    'id' => $id ?? 0,
])
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">新建文章</p>
                @else
                    <p class="top-title">编辑文章</p>
                @endif
            </div>
            <form id="form" onsubmit="return false" 　method="POST">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">文章标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{$title or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入文章标题"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">添加作者：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="author"
                                   value="{{$author or ''}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">关联品牌：</label>
                        </div>
                        <div class="small-14 columns product-brand">
                            <a href="JavaScript:;" class="add-brand button">+ 添加关联品牌</a>
                            @foreach($information_brands_name ?? [] as $key => $information_brand)
                                <div>
                                    <input type="text" value="{{$information_brand or ''}}"
                                           class="brand-input special-input"
                                           id="keyword" placeholder="选择产品品牌(可多选)"
                                           data-validation="required length"
                                           data-validation-length="max50"
                                           data-validation-error-msg="请输入关联品牌"/>

                                    <a href="JavaScript:;" class="close-brand">&nbsp;&nbsp;&nbsp;-</a>
                                    <input id="brand_id" type="hidden" name="brand_ids[]"
                                           value="{{$key or 0}}">
                                </div>
                            @endforeach
                            <div class="content-wrap"></div>
                        </div>
                    </div>
                    <p class="error-tip-brand error-tip" style="display: none;">请不要重复添加</p>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">关联品类：</label>
                        </div>
                        <div class="small-14 columns category-input">
                            <ul class="primary">
                                @foreach(($categorys ?? []) as $category)
                                    <li>{{$category['name']}}
                                        <ul class="list">
                                            @foreach(($category['nodes'] ?? []) as $node)
                                                <li>
                                                    <input name="information_categorys[]" type="checkbox"
                                                           value="{{$node['id']}}"
                                                           class="type-detail" id="category{{$node['id']}}"
                                                           @if(in_array($node['id'],$information_categorys ?? [])) checked @endif
                                                    />
                                                    <label for="category{{$node['id']}}">{{$node['name']}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <div class="clear"></div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">关键词(必填)：</label>
                        </div>
                        <div class="small-14 columns">
                            <ul class="list">
                                @foreach(($themes) as $theme)
                                    <li>
                                        <input name="information_themes[]" type="checkbox" value="{{$theme['id']}}"
                                               class="type-detail" id="theme{{$theme['id']}}"
                                               @if(in_array($theme['id'],$information_themes ?? [])) checked @endif
                                        />
                                        <label for="theme{{$theme['id']}}">{{$theme['name']}}</label>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="clear"></div>
                            <p class="error-tip-category error-tip" style="display: none;">请至少选择一种关键词</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">关联产品型号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="product" value="{{$product_model or ''}}"
                                   data-id="{{$product_id or 0}}"
                                   id="model-keyword"
                                   placeholder="选择产品型号(单选)"/>
                            <input type="hidden" name="product_id" value="{{$product_id or 0}}">
                            <div class="model-content-wrap"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标签(必填)：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="tag_id" id=""
                                    data-validation="required"
                                    data-validation-error-msg="请选择标签">
                                <option value="">选择标签</option>
                                @foreach(($tags ?? []) as $tags)
                                    <option value="{{$tags['id']}}"
                                            @if(($tag_id ?? 0) == $tags['id']) selected @endif>{{$tags['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">添加缩略图：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '预览缩略图',
                                    'name' => 'thumbnail',
                                    'images' => $thumbnail_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-left">发布时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" placeholder="" name="publish_at" class="date"
                                   value="{{$publish_at or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请选择发布时间"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <span class="text-left">是否定时发布：</span>
                        </div>
                        <div class="small-14 columns" style="padding-top: 10px">
                            @foreach($information_publish_status as $name => $value)
                                <input type="radio" name="is_publish" value="{{$name}}" class="checkbox"
                                       id="is_publish{{$name}}"
                                       @if(($is_publish ?? 0) == $name) checked @endif
                                >
                                <label for="is_publish{{$name}}">{{$value}}</label>
                            @endforeach
                                <p class="error-tip-is_publish error-tip" style="display: none;">请至少选择1项</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <span class="text-left">是否发布：</span>
                        </div>
                        <div class="small-14 columns" style="padding-top: 10px">
                            @foreach($information_status as $name => $value)
                                <input type="radio" name="status" value="{{$name}}" class="checkbox"
                                       id="status{{$name}}"
                                       @if(($status ?? 0) == $name) checked @endif
                                >
                                <label for="status{{$name}}">{{$value}}</label>
                            @endforeach
                            <p class="error-tip-status error-tip" style="display: none;">请至少选择1项</p>
                        </div>
                    </div>

                    <div class="article-detail">
                        <div class="small-7 columns text-right">
                            <label class="text-left">正文详情：</label>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- 加载编辑器的容器 -->
                    @include('UEditor::head')
                    <script id="container" name="content" type="text/plain"
                            style="height:200px;">{!! $content or '' !!}</script>
                    <p class="error-tip-content error-tip" style="display: none;">请填写文章内容</p>

                </aside>
                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    @if(!empty($id))
                        <a href="JavaScript:void(0);" class="button conversion" data-id="{{$id ?? 0}}">图片转换</a>
                    @endif
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="brandTpl">
        <div>
            <input type="text"
                   class="brand-input add-brand-input"
                   data-validation="length"
                   data-validation-length="max50"
                   data-validation-error-msg="请输入关联品牌"
                   placeholder="选择产品品牌(可多选)"/>
            <a href="JavaScript:;" class="close-brand">&nbsp;&nbsp;&nbsp;-</a>
            <input type="hidden" id="brand_id" name="brand_ids[]" value=""/>
        </div>
    </script>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection