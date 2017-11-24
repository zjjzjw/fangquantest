<?php
ufa()->extCss([
        'auth/reset-password'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'auth/reset-password'
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
                <h3>找回密码</h3>
                <div class="form-group">
                    <input type="text" name="phone" value="" maxlength="11"
                           autocomplete="off"
                           placeholder="请输入注册时使用的手机号"
                           data-validation="custom"
                           data-validation-regexp="^1\d{10}$"
                           data-validation-error-msg="请输入注册时使用的手机号"/>
                </div>
                <div class=" form-group">
                    <input type="text" name="verifycode" value="" maxlength="6"
                           autocomplete="off"
                           placeholder="短信验证码"
                           data-validation="custom"
                           data-validation-regexp="^\d{6}$"
                           data-validation-error-msg="请输入短信验证码"/>
                    <input type="button" class="validation-code" value="获取验证码"/>
                </div>

                <span class="error-message"></span>

                <div class="form-group">
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="submit" class="btn" value="下一步"/>
                </div>
            </form>

            <form id="reset-form" onsubmit="return false" style="display: none;">
                <h3>重置密码</h3>
                <div class="form-group">
                    <input type="password" name="password" value="" maxlength="12"
                           autocomplete="off"
                           placeholder="新密码，6-12位字母数字组合"
                           data-validation="custom"
                           data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                           data-validation-error-msg="请输入新密码，6-12位字母数字组合"/>
                </div>
                <div class="form-group">
                    <input type="password" name="repeat-password" value="" maxlength="12"
                           autocomplete="off"
                           placeholder="重复密码，6-12位字母数字组合"
                           data-validation="custom"
                           data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                           data-validation-error-msg="请输入重复密码，6-12位字母数字组合"/>
                </div>
                <span class="error-message"></span>

                <div class="form-group">
                    <input type="hidden" name="phone" value="">
                    <input type="hidden" name="verifycode" value="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="submit" class="btn" value="确认修改"/>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="successTpl">
        <div class="success-hint">
            <p>密码修改成功，请登录。</p>
            <p>
                <span class="time">3</span>s后自动跳转
            </p>
        </div>
    </script>
    @include('common.loading-pop')
@endsection