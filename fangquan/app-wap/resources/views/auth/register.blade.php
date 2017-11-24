<?php
ufa()->extCss([
        'auth/register'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'auth/register',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="line"></div>
    <div class="login-box">
        <div class="login-logo">
            <a href="/">
                <img src="/www/images/logo.png" alt="logo">
            </a>
        </div>
        <div class="login-form">

            <form id="form" onsubmit="return false">
                <h3>注册</h3>
                <div class="form-group">
                    <input type="text" name="account" value="" maxlength="32"
                           placeholder="请输入您的手机号"
                           data-validation="required length"
                           data-validation-length="max32"
                           data-validation-error-msg="请输入您的手机号/用户名"/>
                </div>
                <div class=" form-group">
                    <input type="text" name="code" value="" maxlength="6"
                           placeholder="短信验证码"
                           data-validation="required length"
                           data-validation-length="max6"
                           data-validation-error-msg="请输入短信验证码"/>

                    <a href="JavaScript:;" class="validation-code">获取验证码</a>
                </div>
                <div class="form-group">
                    <input type="password" name="password" value="" maxlength="12"
                           placeholder="请输入密码，6-12位，字母数字组合"
                           data-validation="required length"
                           data-validation-length="6 12"
                           data-validation-error-msg="请输入密码"/>

                </div>
                <div class="agreement">
                    <p>点击注册，表示您同意<a href="">《房圈注册协议》</a></p>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="注册房圈"/>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection