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

@section('master.header')
@overwrite

@section('master.main')

    <div class="login-box">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif
        <div class="login-box-body">
            <form id="form" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="帐号"
                           value="{{old('name')}}"
                           data-validation="required length"
                           data-validation-length="max20"
                           data-validation-error-msg="请输入帐号"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="密码"
                           value=""
                           data-validation="required length"
                           data-validation-length="20"
                           data-validation-error-msg="请输入密码"/>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-primary btn-block">登录</button>
            </form>
        </div>
    </div>

@overwrite

@section('master.footer')
@overwrite
