<?php
ufa()->extCss([
    '../lib/autocomplete/autocomplete',
    'fq-user/fq-user/bind'
]);
ufa()->extJs([
    '../lib/autocomplete/autocomplete',
    '../lib/jquery-form-validator/jquery.form-validator',
    'fq-user/fq-user/bind',
]);
ufa()->addParam(['id' => $id ?? 0,]);
?>

@extends('layouts.master') @section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <p class="top-title">添加</p>
            </div>

            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="role_type" id="select-input" data-validation="required"
                                    data-validation-error-msg="请选择账号类型">
                                <option value="">--请选择--</option>
                                @foreach(($fq_user_role_type ?? []) as $key => $name)
                                    <option value="{{$key}}" data-value="{{$key}}"
                                            @if($key == ($role_type ?? 0)) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="hidden" name="relevance_id" value="{{$role_id or 0}}">
                            <input type="text" id="keyword" name=""
                                   value="{{$company_name or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请填写企业名称"/>
                            <div class="content-wrap"></div>
                        </div>
                    </div>

                </aside>

                <div class="text-center" id="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop') @include('common.loading-pop') @include('common.prompt-pop',['type'=>1])
@endsection