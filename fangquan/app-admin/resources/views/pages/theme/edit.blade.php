<?php
ufa()->extCss([
    'theme/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'theme/edit'
]);
ufa()->addParam([
    'id' => $id ?? 0
])
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">添加关键词</p>
                @else
                    <p class="top-title">编辑关键词</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">选择类别：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type" id=""
                                    data-validation="required"
                                    data-validation-error-msg="请选择类别">
                                <option value="">选择类别</option>
                                @foreach(($theme_types ?? []) as $key => $value)
                                    <option value="{{$key}}" @if(($type ?? 0) == $key) selected @endif>{{$value or ''}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="row">
                    <div class="small-8 columns text-right">
                        <label class="text-right">序号：</label>
                    </div>
                    <div class="small-14 columns">
                        <input type="text" name="order" value="{{$order or 0}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入序号">
                    </div>
                </div>
                <div class="row">
                    <div class="small-8 columns text-right">
                        <label class="text-right">关键词：</label>
                    </div>
                    <div class="small-14 columns">
                        <input type="text" name="name" value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入关键词">
                    </div>
                </aside>
                <div class="text-center">
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