<?php
ufa()->extCss([
    'fq-user/fq-user/set-password'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'fq-user/fq-user/set-password',
]);
ufa()->addParam(['id' => $id ?? 0,]);
?>

@extends('layouts.master') @section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">设置密码</p>
                @else
                    <p class="top-title">密码编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">密码：</label>
                        </div>
                        <div class="small-14 columns">
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
