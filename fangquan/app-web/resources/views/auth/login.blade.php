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

            <form id="form" method="POST">
                <div class="form-group">
                    <label class="control-label">
                        <i class="iconfont">&#xe663;</i>
                    </label>
                    <div>
                        <input style="display:none">
                        <input type="text" name="account" value="{{old('account')}}" maxlength="32" autocomplete="off"
                               placeholder="请输入手机号/用户名"
                               data-validation="required length"
                               data-validation-length="max32"
                               data-validation-error-msg="请输入手机号/用户名"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <i class="iconfont">&#xe637;</i>
                    </label>
                    <div>
                        <input type="password" name="password" value="" autocomplete="off"
                               autocomplete="off"
                               placeholder="请输入密码"
                               data-validation="required"
                               data-validation-error-msg="请输入密码"/>
                    </div>
                </div>

                @if (count($errors) > 0)
                    <span class="error-message">
                        @foreach ($errors->all() as $key => $error)
                            {{ $error }}
                        @endforeach
                    </span>
                @endif

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group">
                    <input type="submit" class="btn" value="登录"/>
                </div>
            </form>
            <div class="login-link">
                <a href="{{route('auth.weixin')}}" class="wechat">
                    <i class="iconfont">&#xe606;</i>微信登录
                </a>
                <a href="{{route('reset-password.reset-password')}}" class="forgot-password">忘记密码？</a>
                <a href="{{route('register')}}" class="register">立即注册</a>
            </div>
        </div>
    </div>
@endsection