<?php
ufa()->extCss([
        'auth/login'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'auth/login',
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
                <div class="form-group">
                    <label class="control-label">
                        <i class="iconfont">&#xe85f;</i>
                    </label>
                    <div>
                        <input type="text" name="account" value="" maxlength="32"
                               placeholder="请输入手机号/用户名"
                               data-validation="required length"
                               data-validation-length="max32"
                               data-validation-error-msg="请输入手机号/用户名"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <i class="iconfont">&#xe61b;</i>
                    </label>
                    <div>
                        <input type="password" name="password" value=""
                               placeholder="请输入密码"
                               data-validation="required"
                               data-validation-error-msg="请输入密码"/>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" value="登录"/>
                </div>
            </form>
            <div class="login-link">
                <a href="" class="wechat">
                    <i class="iconfont">&#xe604;</i>微信登录
                </a>
                <a href="reset-password" class="forgot-password">忘记密码？</a>
                <a href="register" class="register">立即注册</a>
            </div>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection