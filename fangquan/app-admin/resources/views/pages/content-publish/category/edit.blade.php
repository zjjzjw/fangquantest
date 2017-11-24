<?php
ufa()->extCss([
        'content-publish/category/edit'
]);
ufa()->extJs([
        'content-publish/category/edit',
        '../lib/jquery-form-validator/jquery.form-validator'
]);
ufa()->addParam(['id' => $id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrap-content">
        <div id="contain">
            @if(empty($id))
                <p class="top-title">分类添加</p>
            @else
                <p class="top-title">分类编辑</p>
            @endif
            <form id="form" onsubmit="return false">
                <div class="content-box">
                    <div class="row">
                        <div class="small-8 columns">
                            <label for="right-label" class="text-right">分类名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入分类名称，长度最大50">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns">
                            <label for="right-label" class="text-right">是否显示：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 8px">

                            @foreach($category_status ?? '' as $key => $name)
                                <input type="radio" name="status" value="{{$key}}" id="checkbox-first"
                                       @if(($status ?? 0) == $key) checked @endif/>
                                <label for="checkbox-first">{{$name}}</label>
                            @endforeach

                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <input type="hidden" name="parent_id" value="{{$parent_id ?? 0}}">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection