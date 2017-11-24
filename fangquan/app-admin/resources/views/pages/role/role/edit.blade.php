<?php
ufa()->extCss([
    'role/role/edit'
]);
ufa()->extJs([
    'role/role/edit',
    '../lib/jquery-form-validator/jquery.form-validator'
]);
ufa()->addParam(['id' => $id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrap-content">
    <div id="contain">
        @if(empty($id))
            <p class="top-title">角色添加</p>
        @else
            <p class="top-title">角色编辑</p>
        @endif
        <form id="form" onsubmit="return false">
            <div class="content-box">
                <div class="row">
                    <div class="small-8 columns">
                        <label for="right-label" class="text-right">角色名称：</label>
                    </div>
                    <div class="small-14 columns">
                        <input type="text" name="name" value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入角色名称，长度最大50">
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 columns">
                        <label for="right-label" class="text-right">角色权限：</label>
                    </div>
                    <div class="small-14 columns" style="padding-top: 20px">
                        @foreach(($role_permissions ?? []) as $role_permission)
                            <div class="permission">
                                <input name="permissions[]" id="checkbox{{$role_permission['id'] or 0}}" type="checkbox"
                                       value="{{$role_permission['id'] or 0}}"
                                       @if(in_array($role_permission['id'],($permissions ?? []))) checked="checked" @endif/>
                                <label for="checkbox{{$role_permission['id'] or 0}}">{{$role_permission['name']}}</label>
                            </div>
                            <p class="error-tip-permissions error-tip" style="display: none;">请选择至少1个角色权限</p>
                        @endforeach
                    </div>
                </div>
            </div>

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