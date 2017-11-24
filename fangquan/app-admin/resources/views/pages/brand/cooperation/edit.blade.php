<?php
ufa()->extCss([
        '../lib/autocomplete/autocomplete',
        'brand/cooperation/edit'
]);
ufa()->extJs([
        '../lib/autocomplete/autocomplete',
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        'brand/cooperation/edit',
]);
ufa()->addParam([
        'id' => $id ?? 0,
        "brand_id" => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">合作客户新增</p>
                @else
                    <p class="top-title">合作客户编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">客户名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="developer_name" value="{{$developer_name or ''}}" id="keyword" placeholder="请输入客户名称（下拉联想选择项）"
                                   data-developer_id="{{$developer_id or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入客户名称（下拉联想选择项）"/>
                            <input type="hidden" name="developer_id" value="{{$developer_id or ''}}">
                            <div class="content-wrap"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">战略期限：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="deadline" value="{{$deadline or ''}}" placeholder="请输入战略期限"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入战略期限"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">是否独家：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="is_exclusive"
                                    data-validation="required"
                                    data-validation-error-msg="请选择是否独家">
                                <option value="">--选择--</option>
                                @foreach($brand_cooperation_type as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($is_exclusive ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">涉及产品范围：</label>
                        </div>
                        <div class="small-14 columns range">
                            @foreach(($categorys ?? []) as $category)
                                <div class="range-container">
                                    <p>{{$category['name']}}</p>
                                    <div class="range-item">
                                        @foreach(($category['nodes'] ?? []) as $node)
                                            <span>
                                            <input type="checkbox" id="category{{$node['id']}}" name="brand_cooperation_categorys[]"
                                                   value="{{$node['id']}}"
                                                   data-validation="checkbox_group"
                                                   data-validation-qty="min1"
                                                   data-validation-error-msg="请至少选择1项"
                                                   @if(in_array($node['id'], $brand_cooperation_categorys ?? [])) checked @endif
                                            />
                                            <label for="category{{$node['id']}}">{{$node['name']}}</label>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="brand_id" value="{{$brand_id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>

    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection