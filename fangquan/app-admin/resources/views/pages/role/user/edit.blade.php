<?php
ufa()->extCss([
    'role/user/edit'
]);
ufa()->extJs([
    'role/user/edit',
    '../lib/jquery-form-validator/jquery.form-validator',
]);
ufa()->addParam(['id' => $id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrap-content">
    <div id="contain">
        @if(empty($id))
            <p class="top-title">修改信息</p>
        @else
            <p class="top-title">编辑信息</p>
        @endif
        <form id="form" onsubmit="return false">

            <div class="row">
                <div class="small-8 columns">
                    <label>账号</label>
                </div>
                <div class="small-14 columns columns">
                    <input type="text" name="account" value="{{$account or ''}}"
                           data-validation="required length"
                           data-validation-length="max255"
                           data-validation-error-msg="请输入账号"/>
                </div>
            </div>

            <div class="row">
                <div class="small-8 columns">
                    <label>公司名称</label>
                </div>
                <div class="small-14 columns">
                    <input type="text" name="company_name" value="{{$company_name or ''}}"
                           data-validation="required length"
                           data-validation-length="max255"
                           data-validation-error-msg="请输入公司名称"/>
                </div>
            </div>

            <div class="row">
                <div class="small-8 columns">
                    <label>职位</label>
                </div>
                <div class="small-14 columns">
                    <input type="text" name="position" value="{{$position or ''}}"
                           data-validation="required length"
                           data-validation-length="max100"
                           data-validation-error-msg="请输入职位"/>
                </div>
            </div>

            <div class="row">
                <div class="small-8 columns">
                    <label>姓名</label>
                </div>
                <div class="small-14 columns">
                    <input type="text" name="name" value="{{$name or ''}}"
                           data-validation="required length"
                           data-validation-length="max255"
                           data-validation-error-msg="请输入姓名"/>
                </div>
            </div>

            <div class="row">
                <div class="small-8 columns">
                    <label>手机号</label>
                </div>
                <div class="small-14 columns">
                    <input type="text" name="phone" value="{{$phone or ''}}"
                           data-validation="required length"
                           data-validation-length="max50"
                           data-validation-error-msg="请输入手机号"/>
                </div>
            </div>

            <div class="row">
                <div class="small-8 columns">
                    <label>用户角色</label>
                </div>
                <div class="small-14 columns" style="padding-top: 20px">
                    @foreach($role_list as $role)
                        <p>
                            <input type="radio" name="role_ids[]" value="{{$role['id']}}"
                                   id="checkbox{{$role['id'] or 0}}"
                                   @if(($roles[0]['id'] ?? [])  == $role['id']) checked @endif
                            />
                            <label for="checkbox{{$role['id'] or 0}}">{{$role['name']}}</label>
                        </p>
                    @endforeach
                        <p class="error-tip-permissions error-tip" style="display: none;">请选择至少1个用户权限</p>
                </div>
            </div>

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