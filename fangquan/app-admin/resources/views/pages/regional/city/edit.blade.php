<?php
ufa()->extCss([
    'regional/city/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'regional/city/edit'
]);
ufa()->addParam(['id' => $id ?? 0]);
?>

@extends('layouts.master')

@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">城市添加</p>
                @else
                    <p class="top-title">城市编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">省份名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="province_id" data-validation="required" data-validation-error-msg="请选择省份">
                                <option value="">--请选择--</option>
                                @foreach(($province_list ?? []) as $province)
                                    <option value="{{$province['id'] or 0}}"
                                            @if(($province_id ?? 0) == $province['id']) selected @endif
                                    >{{$province['name'] or ''}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">城市名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入城市名称"/>
                        </div>
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