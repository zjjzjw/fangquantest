<?php
ufa()->extCss([
    'attribute/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'attribute/edit',
]);
ufa()->addParam([
    'id'               => $id ?? 0,
    'attribute_values' => $attribute_values ?? [],
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">属性新增</p>
                @else
                    <p class="top-title">属性编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>

                    <div class="article-id row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-left">品类：</label>
                        </div>
                        <div class="small-14 columns">
                            <input class="choose-type" type="text" placeholder="请选择品类" readonly="readonly"
                                   value="{{$category_name or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请选择品类">
                            <input type="hidden" id="choose_type" name="category_id"
                                   value="{{$category_id or 0}}">
                        </div>
                        <div class="choose-type-box" style="display: none;">
                            <ul>
                                @foreach(($category_lists ?? []) as $category)
                                    <li class="first-wrap">
                                        <span>{{$category['name']}}</span>
                                        <ul style="
                                        @if(in_array(($category_id ?? 0),$category['node_ids']))
                                                display: block;
                                        @else
                                                display: none;
                                        @endif
                                                ">
                                            @foreach(($category['nodes'] ?? []) as $node)
                                                <li>
                                                    <input id="radio{{$node['id']}}" type="radio" name="category_type"
                                                           data-type-id="{{$node['id']}}"
                                                           value="{{$node['name']}}"
                                                           @if(($category_id ?? 0) == $node['id']) checked @endif
                                                    >
                                                    <label for="radio{{$node['id']}}">{{$node['name']}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">属性：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}" placeholder="请输入属性名称"
                                   data-validation="required"
                                   data-validation-error-msg="请输入属性名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">序号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="order" value="{{$order or 0}}" maxlength="11" placeholder="请输入排序"
                                   data-validation="required length"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入排序"/>
                        </div>
                    </div>

                    <?php $attribute_i = 0; ?>
                    @foreach((!empty($attribute_values) ?  $attribute_values : ['']) as $key => $attribute_value)
                        <div class="row attribute">
                            <div class="small-8 columns text-right">
                                <label class="text-right">值：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="hidden" name="attribute_value_ids[]" value="{{$key}}">
                                <input type="text" name="attribute_values[]" value="{{$attribute_value or ''}}"
                                       placeholder="请输入值"
                                       data-validation="required"
                                       data-validation-error-msg="请输入类别"/>
                                @if($attribute_i == 0)
                                    <a href="JavaScript:;" class="add-attribute">&nbsp;&nbsp;&nbsp;+</a>
                                @else
                                    <a href="JavaScript:;" class="reduce-attribute">&nbsp;&nbsp;&nbsp;-</a>
                                @endif
                            </div>
                        </div>
                        <?php $attribute_i++; ?>
                    @endforeach
                </aside>


                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="attribute_valuesTpl">
        <div class="row attribute">
            <div class="small-8 columns text-right">
                <label class="text-right">值：</label>
            </div>
            <div class="small-14 columns">
                <input type="text" name="attribute_values[]" value="" placeholder="请输入值"
                       data-validation="required"
                       data-validation-error-msg="请输入类别"/>
                <a href="JavaScript:;" class="reduce-attribute">&nbsp;&nbsp;&nbsp;-</a>
            </div>
        </div>
    </script>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection