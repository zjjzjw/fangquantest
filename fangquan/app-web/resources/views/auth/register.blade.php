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
                    <input type="text" name="mobile" value="" maxlength="11" autocomplete="off"
                           placeholder="请输入您的手机号"
                           data-validation="custom"
                           data-validation-regexp="^1\d{10}$"
                           data-validation-error-msg="请输入您的手机号"/>
                </div>
                <div class=" form-group">
                    <input type="text" name="verifycode" value="" maxlength="6" autocomplete="off"
                           placeholder="短信验证码"
                           data-validation="custom"
                           data-validation-regexp="^\d{6}$"
                           data-validation-error-msg="请输入短信验证码"/>

                    <input type="button" class="validation-code" value="获取验证码"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" value="" maxlength="12" autocomplete="off"
                           placeholder="请输入密码，6-12位，字母数字组合"
                           data-validation="custom"
                           data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                           data-validation-error-msg="请输入密码，6-12位，字母数字组合"/>

                </div>
                <span class="error-message"></span>
                <div class="agreement">
                    <p>点击注册，表示您同意<a target="_blank" href="{{route('station.agreement')}}">《房圈注册协议》</a></p>
                </div>
                <div class="form-group">
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="submit" class="btn" value="注册房圈"/>
                </div>
            </form>
        </div>
    </div>

    <script type="text/html" id="successTpl">
        <div class="success-hint">
            <p>注册成功，请登录。</p>
            <p>
                <span class="time">3</span>s后自动跳转
            </p>
        </div>
    </script>
    @include('common.loading-pop')
@endsection