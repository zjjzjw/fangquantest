<?php
ufa()->extCss([
    'personal/account/account-info'
]);
ufa()->extJs([
    'personal/account/account-info'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        @include('pages.personal.personal-left')
        <div class="right-box">
            <div class="account">
                <h3>账号信息</h3>
                <div class="info-box">
                    <h4>基本信息</h4>
                    <div class="info">
                        <div class="nickname">
                            <p>
                                <label>昵称：</label>
                                <span class="span-nickname">{{$fq_user_info['nickname'] or ''}}</span>
                            </p>
                            <a href="JavaScript:;" class="modify modify-nickname">修改</a>
                            <a href="javascript:;" class="modify send-nickname" style="display: none;">确认修改</a>
                            <em class="nickname-error"></em>
                        </div>

                        <div class="mobile">
                            <p>
                                <label>手机号：</label>
                                <span>{{$fq_user_info['mobile'] or ''}}</span>
                            </p>
                            <a href="JavaScript:;" class="modify binding binding-mobile">绑定</a>
                        </div>
                    </div>

                </div>

                <div class="third">
                    <h4>第三方账号</h4>
                    <div class="info">
                        <div class="wechat">
                            <p class="@if(0) high-light @endif">
                                <i class="iconfont">&#xe606;</i>
                                <span>微信账号</span>
                            </p>
                            <a href="{{route('auth.weixin')}}" class="modify binding">绑定</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modify-password">
                <h4>修改密码</h4>
                <div class="set-password">
                    <form id="form" onsubmit="return false">
                        <div class="input-group">
                            <label for="">旧密码</label>
                            <input type="password" placeholder="请输入旧密码" name="old_password" autocomplete="off"
                                   data-validation="custom"
                                   data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                                   data-validation-error-msg="请输入旧密码，6-12位字母数字组合"/>
                        </div>
                        <div class="input-group">
                            <label for="">新密码</label>
                            <input type="password" placeholder="请输入新密码" name="password" autocomplete="off"
                                   data-validation="custom"
                                   data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                                   data-validation-error-msg="请输入新密码，6-12位字母数字组合"/>
                        </div>
                        <div class="input-group">
                            <label for="">确认新密码</label>
                            <input type="password" placeholder="请确认新密码" name="confirm_password" autocomplete="off"
                                   data-validation="custom"
                                   data-validation-regexp="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$"
                                   data-validation-error-msg="请确认新密码，6-12位字母数字组合"/>
                        </div>
                        <span class="error-message"></span>

                        <div class="bottom-group">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="submit" class="save-btn" value="修改密码">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script type="text/html" id="bindingTpl">
        <div class="binding-pop">
            <a href="javascript:;" class="close-btn">
                <i class="iconfont">&#xe676;</i>
            </a>
            <h3>验证你的手机号码，完成手机账号的绑定</h3>
            <div>
                <form id="binding-form" onsubmit="return false">
                    <div class="input-group">
                        <input type="text" placeholder="请输入常用手机号码" name="phone" autocomplete="off"
                               data-validation="custom"
                               data-validation-regexp="^1\d{10}$"
                               data-validation-error-msg="请输入您的手机号"/>
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="请输入6位验证码" name="verifycode" autocomplete="off"
                               data-validation="custom"
                               data-validation-regexp="^\d{6}$"
                               data-validation-error-msg="请输入短信验证码"/>
                        <input type="button" value="获取验证码" class="validation-code">
                    </div>
                    <span class="error-message"></span>
                    <input type="hidden" name="type" value="3">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="submit" value="绑定" class="binding-submit">
                </form>
            </div>

        </div>
    </script>
    <script type="text/html" id="successTpl">
        <div class="success-hint">
            <p>修改完成，请重新登录。</p>
            <p>
                <span class="time">3</span>s后自动跳转
            </p>
            <p>
                <a href="<?= route('login') ?>" class="log-again">重新登录</a>
            </p>
        </div>
    </script>
    @include('common.loading-pop')
@endsection