<?php
ufa()->extCss([
    'role/user/set-password'
]);
ufa()->extJs([
    'role/user/set-password',
    '../lib/jquery-form-validator/jquery.form-validator',
]);
ufa()->addParam(['id' => $id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">修改密码</p>
                @else
                    <p class="top-title">设置密码</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label>密码：</label>
                        </div>
                        <div class="small-14 columns columns">
                            <input type="password" name="password"
                                   placeholder="请输入密码，6-12位，字母数字组合"
                                   data-validation="custom"
                                   data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                                   data-validation-error-msg="请输入密码，6-12位，字母数字组合"/>
                        </div>
                    </div>
                </aside>
                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="submit" class="button small-width save" value="保存">
                    <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection