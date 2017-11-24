<?php
ufa()->extCss([
        'provider/provider-rank-category/edit',
        '../lib/autocomplete/autocomplete',
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'provider/provider-rank-category/edit',
        '../lib/autocomplete/autocomplete',
]);

ufa()->addParam(
    [
        'id' => $id ?? 0,
        'provider_id' => $provider_id ?? 0,
    ]
);
?>




@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">添加</p>
                @else
                    <p class="top-title">编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" id="provider" name="provider" value="{{$provider_name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-provider-id="{{$provider_id or 0}}"
                                   data-validation-error-msg="请添加公司"/>
                            <input type="hidden" name="provider_id" value="{{$provider_id or 0}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-right">品类：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="category_id" class="options"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选品类">
                                <option value="">--请选择品类--</option>
                                @foreach(($product_category ?? []) as $category)
                                    <option value="{{$category['id']}}"
                                            @if(($category_id ?? 0) == $category['id']) selected @endif
                                    >{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">排名：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="rank" value="{{$rank or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加排名"/>
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